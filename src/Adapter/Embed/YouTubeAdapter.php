<?php

namespace Derby\Media\Adapter\Embed;

use Derby\Adapter\EmbedAdapterInterface;
use Google_Client;
use Google_Service_YouTube;

class YouTubeAdapter implements EmbedAdapterInterface
{
    const ADAPTER_YOU_TUBE = 'ADAPTER\EMBED\YOU_TUBE';

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
     * @param Google_Service_YouTube $service
     */
    public function __construct(Google_Client $client, Google_Service_YouTube $service)
    {
        $this->client  = $client;
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_YOU_TUBE;
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * @param $key
     * @return mixed
     */
    public function render($key)
    {
        // TODO: Implement render() method.
    }


}
