<?php

namespace Derby\Adapter\YouTube;

use Derby\AdapterInterface;
use Derby\Media\YouTube\YouTubeVideo;
use Derby\Exception\MediaNotFoundException;
use Google_Client;
use Google_Service_YouTube;
use Derby\Exception\DerbyException;

class YouTubeVideoAdapter implements AdapterInterface
{
    const ADAPTER_YOU_TUBE_VIDEO = 'ADAPTER\EMBED\YOU_TUBE_VIDEO';

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
     * @var array
     */
    protected $videos = array();


    /**
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->service = new Google_Service_YouTube($client);
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
     * @param null $key
     * @return YouTubeVideo
     * @throws MediaNotFoundException
     */
    public function refresh($key = null)
    {
        if (isset($this->videos[$key])) {
            unset($this->videos[$key]);
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
        $this->videos = array();

        return $this;
    }

    /**
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    protected function loadVideoData($key)
    {
        if (isset($this->videos[$key])) {
            return;
        }

        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->youTubeService->videos->listVideos(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Video) {
            $this->videos[$key] = $items[0];
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
        $snippet = $this->videos[$key]->getSnippet();

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
        $statistics = $this->videos[$key]->getStatistics();

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

        $contentDetails = $this->videos[$key]->getContentDetails();

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

        $status = $this->videos[$key]->getStatus();

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
