<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Cache\DerbyCache;
use Derby\Cache\PaginatedDerbyCache;
use Derby\Media\YouTube\YouTubeChannel;
use Derby\MediaInterface;
use Derby\Exception\MediaNotFoundException;

class YouTubeChannelAdapter implements CollectionAdapterInterface
{

    const ADAPTER_YOU_TUBE_CHANNEL = 'ADAPTER\EMBED\YOU_TUBE_CHANNEL';
    const CACHE_CHANNEL = 'channel';
    const CACHE_CHANNEL_ITEMS = 'channel_items';
    const CACHE_CHANNEL_ITEMS_COUNTS = 'channel_item_count';


    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var \Google_Service_YouTube_Channel
     */
    protected $service;

    /**
     * @var YouTubeVideoAdapter
     */
    protected $videoAdapter;

    /**
     * @var DerbyCache
     */
    protected $cache;

    /**
     * @var
     */
    protected $paginatedCache;

    /**
     * @param \Google_Client $client
     * @param YouTubeVideoAdapter $videoAdapter
     * @param DerbyCache $cache
     */
    public function __construct(\Google_Client $client, YouTubeVideoAdapter $videoAdapter, DerbyCache $cache)
    {
        $this->client = $client;
        $this->service = new \Google_Service_YouTube($client);
        $this->videoAdapter = $videoAdapter;
        $this->cache = $cache;
        $this->paginatedCache = new PaginatedDerbyCache($cache);
    }


    /**
     * @param $key
     * @return boolean
     */
    public function exists($key)
    {
        $result = $this->service->channels->listChannels('id', array('id' => $key));

        return $result->count() == 0 ? false : true;
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_YOU_TUBE_CHANNEL;
    }

    /**
     * Pull data again from Google
     * @param $key
     * @return MediaInterface
     * @throws MediaNotFoundException
     */
    public function refresh($key)
    {
        if ($this->cache->contains(self::CACHE_CHANNEL, $key)) {
            $this->cache->delete(self::CACHE_CHANNEL, $key);
        }
        $this->loadChannelData($key);

        return $this->getMedia($key);
    }

    /**
     * Clear local cache
     */
    public function clearCache()
    {
        $this->cache->deleteAll(self::CACHE_CHANNEL);
        $this->cache->deleteAll(self::CACHE_CHANNEL_ITEMS);
        $this->cache->deleteAll(self::CACHE_CHANNEL_ITEMS_COUNTS);
    }

    /**
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    protected function loadChannelData($key)
    {
        if ($this->cache->contains(self::CACHE_CHANNEL, $key)) {
            return;
        }

        $response = $this->service->channels->listChannels(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Channel) {
            $this->cache->save(self::CACHE_CHANNEL, $key, $items[0]);
        } else {
            throw new MediaNotFoundException();
        }
    }

    protected function loadItems($key, $page = 1, $limit = 10)
    {
        if ($limit > 50) {
            throw new \Exception('YouTube limits the maximum number of results to 50');
        }

        if ($this->paginatedCache->contains(self::CACHE_CHANNEL_ITEMS, $key, $page, $limit)) {
            return;
        }


        $search = $this->service->search;
        $currentPage = 1;
        $nextPageToken = null;
        while ($currentPage <= $page) {

            if ($this->paginatedCache->contains(self::CACHE_CHANNEL_ITEMS, $key, $currentPage, $limit)) {
                continue;
            }


            $response = $search->listSearch(
                'id,snippet',
                array('channelId' => $key, 'type' => 'video', 'maxResults' => $limit, 'pageToken' => $nextPageToken)
            );

            if ($currentPage == 1) {
                $pageInfo = $response->getPageInfo();
                $this->cache->save(self::CACHE_CHANNEL_ITEMS_COUNTS, $key, $pageInfo->getTotalResults());
            }

            $ids = array();
            foreach ($response->getItems() as $item) {
                $ids[] = $item->getId()->getVideoId();
            }
            $this->paginatedCache->save(self::CACHE_CHANNEL_ITEMS, $key, $currentPage, $limit, $ids);


            $nextPageToken = $response->getNextPageToken();
            if (!$nextPageToken) {
                break;
            }

            $currentPage++;
        }
    }

    /**
     * @param $key
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getItems($key, $page = 1, $limit = 10)
    {
        $this->loadChannelData($key);
        $this->loadItems($key, $page, $limit);

        $offset = ($page - 1) * $limit;
        $videoIds = $this->paginatedCache->fetch(self::CACHE_CHANNEL_ITEMS, $key, $page, $limit);
        if (!$videoIds) {
            return array();
        }

        $ids = array_slice($videoIds, $offset, $limit);

        $return = array();
        foreach ($ids as $id) {
            $return[] = $this->videoAdapter->getMedia($id);
        }

        return $return;
    }

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key)
    {
        return new YouTubeChannel($key, $this);
    }

    /**
     * Returns back true if $item is in collection
     * @param $key
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains($key, MediaInterface $item)
    {
        $this->loadChannelData($key);

        $video = $this->videoAdapter->getMedia($item->getKey());

        if (!$video->exists()) {
            return false;
        }

        return $video->getChannelId() == $key;
    }

    /**
     * Returns the number of items in the collection
     * @param $key
     * @return int
     */
    public function count($key)
    {
        $this->loadChannelData($key);
        $this->loadItems($key, 1, 1);

        return $this->cache->fetch(self::CACHE_CHANNEL_ITEMS_COUNTS, $key);
    }

    public function getTitle($key)
    {
        $this->loadChannelData($key);
        $channel = $this->cache->fetch(self::CACHE_CHANNEL, $key);
        $snippet = $channel->getSnippet();

        return $snippet['title'];
    }
}