<?php

namespace Derby\Adapter\Embed;

use Derby\Adapter\EmbedAdapterInterface;
use Derby\Media\Embed\YouTube\YouTubeVideo;
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
        return new YouTubeVideo($key, $this, $this->client);
    }
}
