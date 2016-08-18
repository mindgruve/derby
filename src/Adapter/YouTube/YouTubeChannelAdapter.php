<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Cache\CacheKey;
use Derby\Cache\DerbyCache;
use Derby\Cache\PaginatedCache;
use Derby\Cache\ResultPage;
use Derby\Media\YouTube\YouTubeChannel;
use Derby\MediaInterface;
use Derby\Exception\MediaNotFoundException;

class YouTubeChannelAdapter implements CollectionAdapterInterface
{

    const ADAPTER_YOU_TUBE_CHANNEL = 'ADAPTER\EMBED\YOU_TUBE_CHANNEL';

    /**
     * @var string
     */
    protected $adapterKey;

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
     * @param string $adapterKey
     * @param \Google_Client $client
     * @param YouTubeVideoAdapter $videoAdapter
     * @param DerbyCache $cache
     */
    public function __construct(
        $adapterKey,
        \Google_Client $client,
        YouTubeVideoAdapter $videoAdapter,
        DerbyCache $cache
    ) {
        $this->adapterKey = $adapterKey;
        $this->client = $client;
        $this->service = new \Google_Service_YouTube($client);
        $this->videoAdapter = $videoAdapter;
        $this->cache = $cache;
        $this->paginatedCache = new PaginatedCache($cache);
    }

    /**
     * @param $adapterKey
     * @return $this
     */
    public function setAdapterKey($adapterKey)
    {
        $this->adapterKey = $adapterKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdapterKey()
    {
        return $this->adapterKey;
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
        if ($this->cache->contains(CacheKey::YOUTUBE_CHANNEL, $key)) {
            $this->cache->delete(CacheKey::YOUTUBE_CHANNEL, $key);
        }
        $this->loadChannelData($key);

        return $this->getMedia($key);
    }

    /**
     * Clear local cache
     */
    public function clearCache()
    {
        $this->cache->deleteAll(CacheKey::YOUTUBE_CHANNEL);
        $this->cache->deleteAll(CacheKey::YOUTUBE_CHANNEL_ITEMS);
        $this->cache->deleteAll(CacheKey::YOUTUBE_CHANNEL_ITEMS_COUNTS);
    }

    /**
     * Retrieves data from API
     * @param $key
     * @throws MediaNotFoundException
     */
    protected function loadChannelData($key)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_CHANNEL, $key)) {
            return;
        }

        $response = $this->service->channels->listChannels(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Channel) {
            $this->cache->save(CacheKey::YOUTUBE_CHANNEL, $key, $items[0]);
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

        if ($this->paginatedCache->contains(CacheKey::YOUTUBE_CHANNEL_ITEMS, $key, $limit, $continuationToken)) {
            return $this->paginatedCache->fetch(CacheKey::YOUTUBE_CHANNEL_ITEMS, $key, $limit, $continuationToken);
        }

        $search = $this->service->search;
        $response = $search->listSearch(
            'id,snippet',
            array('channelId' => $key, 'type' => 'video', 'maxResults' => $limit, 'pageToken' => $continuationToken)
        );

        if (is_null($continuationToken)) {
            $pageInfo = $response->getPageInfo();
            $this->cache->save(CacheKey::YOUTUBE_CHANNEL_ITEMS_COUNTS, $key, $pageInfo->getTotalResults());
        }

        $items = array();
        foreach ($response->getItems() as $item) {
            $id = $item->getId()->getVideoId();
            $items[] = $this->videoAdapter->getMedia($id);
        }

        $resultPage = new ResultPage($items, $limit, $response->getNextPageToken());
        $this->paginatedCache->save(CacheKey::YOUTUBE_CHANNEL_ITEMS, $resultPage, $key, $limit, $continuationToken);

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

        return $this->cache->fetch(CacheKey::YOUTUBE_CHANNEL_ITEMS_COUNTS, $key);
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
        $channel = $this->cache->fetch(CacheKey::YOUTUBE_CHANNEL, $key);
        $snippet = $channel->getSnippet();

        return $snippet['title'];
    }
}