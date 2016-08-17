<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Cache\DerbyCache;
use Derby\Cache\PaginatedCache;
use Derby\Cache\ResultPage;
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
     * @var PaginatedCache
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
        $this->paginatedCache = new PaginatedCache($cache);
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
     * @param $key
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

    /**
     * @param $key
     * @param int $limit
     * @param null $continuationToken
     * @return ResultPage
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getItems($key, $limit = 10, $continuationToken = null)
    {
        $this->loadChannelData($key);

        if ($limit > 50) {
            throw new \Exception('YouTube limits the maximum number of results to 50');
        }

        if ($this->paginatedCache->contains(self::CACHE_CHANNEL_ITEMS, $key, $limit, $continuationToken)) {
            return $this->paginatedCache->fetch(self::CACHE_CHANNEL_ITEMS, $key, $limit, $continuationToken);
        }

        $search = $this->service->search;
        $nextPageToken = null;

        $response = $search->listSearch(
            'id,snippet',
            array('channelId' => $key, 'type' => 'video', 'maxResults' => $limit, 'pageToken' => $nextPageToken)
        );

        if (is_null($continuationToken)) {
            $pageInfo = $response->getPageInfo();
            $this->cache->save(self::CACHE_CHANNEL_ITEMS_COUNTS, $key, $pageInfo->getTotalResults());
        }

        $items = array();
        foreach ($response->getItems() as $item) {
            $id = $item->getId()->getVideoId();
            $items[] = $this->videoAdapter->getMedia($id);
        }

        $resultPage = new ResultPage($items, $limit, $response->getNextPageToken());
        $this->paginatedCache->save(self::CACHE_CHANNEL_ITEMS, $resultPage, $key, $limit, $continuationToken);

        return $resultPage;
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
        $this->getItems($key);

        return $this->cache->fetch(self::CACHE_CHANNEL_ITEMS_COUNTS, $key);
    }

    /**
     * Get Channel Title
     * @param $key
     * @return mixed
     * @throws MediaNotFoundException
     */
    public function getTitle($key)
    {
        $this->loadChannelData($key);
        $channel = $this->cache->fetch(self::CACHE_CHANNEL, $key);
        $snippet = $channel->getSnippet();

        return $snippet['title'];
    }
}