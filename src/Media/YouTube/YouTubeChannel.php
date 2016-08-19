<?php

namespace Derby\Media\YouTube;

use Derby\Adapter\YouTube\YouTubeChannelAdapter;
use Derby\Adapter\AdapterInterface;
use Derby\Exception\NotSupportedByAdapterException;
use Derby\Media\CollectionInterface;
use Derby\Media\MediaInterface;
use Derby\Exception\DerbyException;

class YouTubeChannel implements CollectionInterface
{

    /**
     * @var \Google_Service_YouTube
     */
    protected $youTubeService;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var \Google_Service_YouTube_Channel
     */
    protected $channel;


    /**
     * @param $channelKey
     * @param YouTubeChannelAdapter $adapter
     */
    public function __construct($channelKey, YouTubeChannelAdapter $adapter)
    {
        $this->channelKey = $channelKey;
        $this->adapter = $adapter;
    }

    public function getTitle()
    {
        return $this->adapter->getTitle($this->channelKey);
    }

    /**
     * @param MediaInterface $item
     * @return $this
     * @throws NotSupportedByAdapterException
     */
    public function add(MediaInterface $item)
    {
        throw new NotSupportedByAdapterException('YouTube adapter does not support adding videos yet');
    }

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item)
    {
        return $this->adapter->contains($this->getKey(), $item);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->adapter->count($this->getKey());
    }

    /**
     * @return boolean
     */
    public function exists()
    {
        return $this->adapter->exists($this->getKey());
    }

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param int $limit
     * @param null $continuationToken
     * @return \Derby\Cache\ResultPage
     * @throws \Exception
     */
    public function getItems($limit = 10, $continuationToken = null)
    {
        return $this->adapter->getItems($this->getKey(), $limit, $continuationToken);
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        return $this->channelKey;
    }

    /**
     * @param MediaInterface $item
     * @return $this
     * @throws NotSupportedByAdapterException
     */
    public function remove(MediaInterface $item)
    {
        throw new NotSupportedByAdapterException('YouTube adapter does not support removing videos yet');
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     * @throws DerbyException
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        if (!$adapter instanceof YouTubeChannelAdapter) {
            throw new DerbyException('Invalid Adapter use for YouTube Channel');
        }
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Set key
     * @param $channelKey
     * @return mixed
     */
    public function setKey($channelKey)
    {
        $this->channelKey = $channelKey;
    }

    /**
     * Refresh data from Google
     */
    public function refresh()
    {
        $this->adapter->refresh($this->getKey());
    }


}
