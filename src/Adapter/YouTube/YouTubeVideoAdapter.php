<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\AdapterInterface;
use Derby\Cache\CacheKey;
use Derby\Media\YouTube\YouTubeVideo;
use Derby\Exception\MediaNotFoundException;
use Google_Client;
use Google_Service_YouTube;
use Derby\Exception\DerbyException;
use Derby\Cache\DerbyCache;

class YouTubeVideoAdapter implements AdapterInterface
{

    protected $adapterKey;

    /**
     * @var Google_Client
     */
    protected $client;

    /**
     * @var Google_Service_YouTube
     */
    protected $service;


    /**
     * @var \Google_Service_YouTube
     */
    protected $youTubeService;

    /**
     * @var DerbyCache
     */
    protected $cache;

    /**
     * @param $adapterKey
     * @param Google_Client $client
     * @param DerbyCache $cache
     */
    public function __construct($adapterKey, Google_Client $client, DerbyCache $cache)
    {
        $this->adapterKey = $adapterKey;
        $this->client = $client;
        $this->service = new Google_Service_YouTube($client);
        $this->cache = $cache;
    }

    /**
     * @param $adapterKey
     * @return $this
     */
    public function setAdapterKey($adapterKey)
    {
        $this->adapterKey = $adapterKey;
    }

    /**
     * @return string
     */
    public function getAdapterKey()
    {
        return $this->adapterKey;
    }

    /**
     * Pull data from Google again
     * @param string $videoKey
     * @return YouTubeVideo
     * @throws MediaNotFoundException
     */
    public function refresh($videoKey)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_VIDEO, $videoKey)) {
            $this->cache->delete(CacheKey::YOUTUBE_VIDEO, $videoKey);
        }
        $this->loadVideoData($videoKey);

        return $this->getMedia($videoKey);
    }

    /**
     * Clear local cache
     * @return $this
     */
    public function clearCache()
    {
        $this->cache->deleteAll(CacheKey::YOUTUBE_VIDEO);

        return $this;
    }

    /**
     * Retrieves data from API
     * @param $videoKey
     * @throws MediaNotFoundException
     */
    protected function loadVideoData($videoKey)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_VIDEO, $videoKey)) {
            return;
        }
        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->youTubeService->videos->listVideos(
            'snippet,statistics,status,contentDetails',
            array('id' => $videoKey)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Video) {
            $this->cache->save(CacheKey::YOUTUBE_VIDEO, $videoKey, $items[0]);
        } else {
            throw new MediaNotFoundException();
        }
    }

    /**
     * Get Snippet object of a video
     * https://developers.google.com/youtube/v3/docs/videos#snippet
     * @param $videoKey
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getSnippetField($videoKey, $field)
    {
        $this->loadVideoData($videoKey);
        $snippet = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $videoKey)->getSnippet();

        return $snippet[$field];
    }

    /**
     * Get Statistic object of a video
     * https://developers.google.com/youtube/v3/docs/videos#statistics
     * @param $videoKey
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getStatisticsField($videoKey, $field)
    {
        $this->loadVideoData($videoKey);
        $statistics = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $videoKey)->getStatistics();

        return $statistics[$field];
    }

    /**
     * Get ContentDetails object of a video
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails
     * @param $videoKey
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getContentDetailsField($videoKey, $field)
    {
        $this->loadVideoData($videoKey);

        $contentDetails = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $videoKey)->getContentDetails();

        return $contentDetails[$field];
    }

    /**
     * Get Status object of a video
     * https://developers.google.com/youtube/v3/docs/videos#status
     * @param $videoKey
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getStatusField($videoKey, $field)
    {
        $this->loadVideoData($videoKey);

        $status = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $videoKey)->getStatus();

        return $status[$field];
    }


    /**
     * @param $videoKey
     * @return bool
     */
    public function exists($videoKey)
    {
        $result = $this->service->videos->listVideos('id', array('id' => $videoKey));

        return $result->count() == 0 ? false : true;
    }

    /**
     * @param $videoKey
     * @return YouTubeVideo
     */
    public function getMedia($videoKey)
    {
        return new YouTubeVideo($videoKey, $this);
    }

    /**
     * Parse a URL and get the YouTubeVideo object associated with it
     *
     * @param $url
     * @return YouTubeVideo
     * @throws DerbyException
     */
    public function parseYouTubeURL($url)
    {
        /**
         * https://www.youtube.com/watch?v={{ID}}
         */
        if (preg_match('/youtube\.com\/watch\?v=(.*)/', $url, $matches)) {
            $videoKey = $matches[1];

            return $this->getMedia($videoKey);
        }

        /**
         * https://www.youtube.com/embed/{{ID}}
         */
        if (preg_match('/youtube\.com\/embed\/(.*)/', $url, $matches)) {
            $videoKey = $matches[1];

            return $this->getMedia($videoKey);
        }

        /**
         * https://youtu.be/{{ID}}
         */
        if (preg_match('/youtu\.be\/(.*)/', $url, $matches)) {
            $videoKey = $matches[1];

            return $this->getMedia($videoKey);
        }

        throw new DerbyException('Unable to parse YouTube URL');
    }
}
