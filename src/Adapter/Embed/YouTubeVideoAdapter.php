<?php

namespace Derby\Adapter\Embed;

use Derby\Adapter\EmbedAdapterInterface;
use Derby\Media\Embed\YouTube\YouTubeVideo;
use Derby\Exception\MediaNotFoundException;
use Google_Client;
use Google_Service_YouTube;

class YouTubeVideoAdapter implements EmbedAdapterInterface
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
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    protected function load($key)
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
        $this->initialized = true;
    }

    /**
     * Get Snippet object of a video
     * https://developers.google.com/youtube/v3/docs/videos#snippet
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getSnippetField($key, $field)
    {
        $this->load($key);
        $snippet = $this->videos[$key]->getSnippet();

        if (isset($snippet[$field])) {
            return $snippet[$field];
        }

        throw new \Exception('Invalid field for Snippet Object');
    }

    /**
     * Get Statistic object of a video
     * https://developers.google.com/youtube/v3/docs/videos#statistics
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getStatisticsField($key, $field)
    {
        $this->load($key);
        $statistics = $this->videos[$key]->getStatistics();

        if (isset($statistics[$field])) {
            return $statistics[$field];
        }

        throw new \Exception('Invalid field for Statistics Object');
    }

    /**
     * Get ContentDetails object of a video
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getContentDetailsField($key, $field)
    {
        $this->load($key);

        $contentDetails = $this->videos[$key]->getContentDetails();

        if (isset($contentDetails[$field])) {
            return $contentDetails[$field];
        }

        throw new \Exception('Invalid field for ContentDetails Object');
    }

    /**
     * Get Status object of a video
     * https://developers.google.com/youtube/v3/docs/videos#status
     * @param $key
     * @param $field
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    public function getStatusField($key, $field)
    {
        $this->load($key);

        $status = $this->videos[$key]->getStatus();

        if (isset($status[$field])) {
            return $status[$field];
        }

        throw new \Exception('Invalid field for Status Object');
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
}
