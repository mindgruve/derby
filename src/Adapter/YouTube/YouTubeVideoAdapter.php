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
    const ADAPTER_YOU_TUBE_VIDEO = 'ADAPTER\EMBED\YOU_TUBE_VIDEO';

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
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_YOU_TUBE_VIDEO;
    }

    /**
     * Pull data from Google again
     * @param string $key
     * @return YouTubeVideo
     * @throws MediaNotFoundException
     */
    public function refresh($key)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_VIDEO, $key)) {
            $this->cache->delete(CacheKey::YOUTUBE_VIDEO, $key);
        }
        $this->loadVideoData($key);

        return $this->getMedia($key);
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
     * @param $key
     * @throws MediaNotFoundException
     */
    protected function loadVideoData($key)
    {
        if ($this->cache->contains(CacheKey::YOUTUBE_VIDEO, $key)) {
            return;
        }
        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->youTubeService->videos->listVideos(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Video) {
            $this->cache->save(CacheKey::YOUTUBE_VIDEO, $key, $items[0]);
        } else {
            throw new MediaNotFoundException();
        }
    }

    /**
     * Get Snippet object of a video
     * https://developers.google.com/youtube/v3/docs/videos#snippet
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getSnippetField($key, $field)
    {
        $this->loadVideoData($key);
        $snippet = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $key)->getSnippet();

        if (isset($snippet[$field])) {
            return $snippet[$field];
        }

        throw new DerbyException('Invalid field for Snippet Object');
    }

    /**
     * Get Statistic object of a video
     * https://developers.google.com/youtube/v3/docs/videos#statistics
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getStatisticsField($key, $field)
    {
        $this->loadVideoData($key);
        $statistics = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $key)->getStatistics();

        if (isset($statistics[$field])) {
            return $statistics[$field];
        }

        throw new DerbyException('Invalid field for Statistics Object');
    }

    /**
     * Get ContentDetails object of a video
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getContentDetailsField($key, $field)
    {
        $this->loadVideoData($key);

        $contentDetails = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $key)->getContentDetails();

        if (isset($contentDetails[$field])) {
            return $contentDetails[$field];
        }

        throw new DerbyException('Invalid field for ContentDetails Object');
    }

    /**
     * Get Status object of a video
     * https://developers.google.com/youtube/v3/docs/videos#status
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws DerbyException
     */
    public function getStatusField($key, $field)
    {
        $this->loadVideoData($key);

        $status = $this->cache->fetch(CacheKey::YOUTUBE_VIDEO, $key)->getStatus();

        if (isset($status[$field])) {
            return $status[$field];
        }

        throw new DerbyException('Invalid field for Status Object');
    }


    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        $result = $this->service->videos->listVideos('id', array('id' => $key));

        return $result->count() == 0 ? false : true;
    }

    /**
     * @param $key
     * @return YouTubeVideo
     */
    public function getMedia($key)
    {
        return new YouTubeVideo($key, $this);
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
            $key = $matches[1];

            return $this->getMedia($key);
        }

        /**
         * https://www.youtube.com/embed/{{ID}}
         */
        if (preg_match('/youtube\.com\/embed\/(.*)/', $url, $matches)) {
            $key = $matches[1];

            return $this->getMedia($key);
        }

        /**
         * https://youtu.be/{{ID}}
         */
        if (preg_match('/youtu\.be\/(.*)/', $url, $matches)) {
            $key = $matches[1];

            return $this->getMedia($key);
        }

        throw new DerbyException('Unable to parse YouTube URL');
    }
}
