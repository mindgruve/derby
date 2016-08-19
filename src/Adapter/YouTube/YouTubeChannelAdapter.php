<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Cache\CacheKey;
use Derby\Cache\DerbyCache;
use Derby\Cache\PaginatedCache;
use Derby\Cache\ResultPage;
use Derby\Media\YouTube\YouTubeChannel;
use Derby\Media\MediaInterface;
use Derby\Exception\MediaNotFoundException;

class YouTubeChannelAdapter implements CollectionAdapterInterface
{

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
     * @param $channelKey
     * @return boolean
     */
    public function exists($channelKey)
    {
        $result = $this->service->channels->listChannels('id', array('id' => $channelKey));

        return $result->count() == 0 ? false : true;
    }

    /**
     * Pull data again from Google
     * @param $channelKey
     * @return MediaInterface
     * @throws MediaNotFoundException
     */
    public function refresh($channelKey)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_CHANNEL, $channelKey)) {
            $this->cache->delete(CacheKey::YOUTUBE_CHANNEL, $channelKey);
        }
        $this->loadChannelData($channelKey);

        return $this->getMedia($channelKey);
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
     * @param $channelKey
     * @throws MediaNotFoundException
     */
    protected function loadChannelData($channelKey)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_CHANNEL, $channelKey)) {
            return;
        }

        $response = $this->service->channels->listChannels(
            'snippet,statistics,status,contentDetails',
            array('id' => $channelKey)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Channel) {
            $this->cache->save(CacheKey::YOUTUBE_CHANNEL, $channelKey, $items[0]);
        } else {
            throw new MediaNotFoundException();
        }
    }

    /**
     * @param $channelKey
     * @param int $limit
     * @param null $continuationToken
     * @return ResultPage
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getItems($channelKey, $limit = 10, $continuationToken = null)
    {
        $this->loadChannelData($channelKey);

        if ($limit > 50) {
            throw new \Exception('YouTube limits the maximum number of results to 50');
        }

        if ($this->paginatedCache->contains(CacheKey::YOUTUBE_CHANNEL_ITEMS, $channelKey, $limit, $continuationToken)) {
            return $this->paginatedCache->fetch(CacheKey::YOUTUBE_CHANNEL_ITEMS, $channelKey, $limit, $continuationToken);
        }

        $search = $this->service->search;
        $response = $search->listSearch(
            'id,snippet',
            array('channelId' => $channelKey, 'type' => 'video', 'maxResults' => $limit, 'pageToken' => $continuationToken)
        );

        if (is_null($continuationToken)) {
            $pageInfo = $response->getPageInfo();
            $this->cache->save(CacheKey::YOUTUBE_CHANNEL_ITEMS_COUNTS, $channelKey, $pageInfo->getTotalResults());
        }

        $items = array();
        foreach ($response->getItems() as $item) {
            $id = $item->getId()->getVideoId();
            $items[] = $this->videoAdapter->getMedia($id);
        }

        $resultPage = new ResultPage($items, $limit, $response->getNextPageToken());
        $this->paginatedCache->save(CacheKey::YOUTUBE_CHANNEL_ITEMS, $resultPage, $channelKey, $limit, $continuationToken);

        return $resultPage;
    }

    /**
     * @param $channelKey
     * @return MediaInterface
     */
    public function getMedia($channelKey)
    {
        return new YouTubeChannel($channelKey, $this);
    }

    /**
     * Returns back true if $item is in collection
     * @param $channelKey
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains($channelKey, MediaInterface $item)
    {
        $this->loadChannelData($channelKey);

        $video = $this->videoAdapter->getMedia($item->getKey());

        if (!$video->exists()) {
            return false;
        }

        return $video->getChannelId() == $channelKey;
    }

    /**
     * Returns the number of items in the collection
     * @param $channelKey
     * @return int
     */
    public function count($channelKey)
    {
        $this->getItems($channelKey);

        return $this->cache->fetch(CacheKey::YOUTUBE_CHANNEL_ITEMS_COUNTS, $channelKey);
    }

    /**
     * Get Channel Title
     * @param $channelKey
     * @return mixed
     * @throws MediaNotFoundException
     */
    public function getTitle($channelKey)
    {
        $this->loadChannelData($channelKey);
        $channel = $this->cache->fetch(CacheKey::YOUTUBE_CHANNEL, $channelKey);
        $snippet = $channel->getSnippet();

        return $snippet['title'];
    }
}