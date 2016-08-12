<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Media\YouTube\YouTubeChannel;
use Derby\MediaInterface;
use Derby\Exception\MediaNotFoundException;

class YouTubeChannelAdapter implements CollectionAdapterInterface
{

    const ADAPTER_YOU_TUBE_CHANNEL = 'ADAPTER\EMBED\YOU_TUBE_CHANNEL';

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var \Google_Service_YouTube_Channel
     */
    protected $service;

    /**
     * @var array
     */
    protected $channels = array();


    /**
     * @param \Google_Client $client
     */
    public function __construct(\Google_Client $client)
    {
        $this->client = $client;
        $this->service = new \Google_Service_YouTube($client);
    }


    /**
     * @param $key
     * @return boolean
     */
    public function exists($key)
    {
        $result = $this->service->channels->listChannels(array('id' => $key));

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
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    public function load($key, $force = false)
    {
        if (!$force) {
            if (isset($this->channels[$key])) {
                return;
            }
        }

        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->service->channels->listVideos(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Channel) {
            $this->channels[$key] = $items[0];
        } else {
            throw new MediaNotFoundException();
        }
        $this->initialized = true;
    }

    /**
     * @param $key
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getItems($key, $page = 1, $limit = 10)
    {
        $search = $this->service->search;
    }

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key)
    {
        return new YouTubeChannel($key, $this);
    }
}