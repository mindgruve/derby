<?php

namespace Derby\Media\YouTube;

use Derby\Adapter\YouTube\YouTubeChannelAdapter;
use Derby\AdapterInterface;
use Derby\Exception\NotSupportedByAdapterException;
use Derby\Media\CollectionInterface;
use Derby\MediaInterface;
use Derby\Exception\DerbyException;

class YouTubeChannel implements CollectionInterface
{
    const EMBED_YOUTUBE_CHANNEL = 'EMBED/YOUTUBE/CHANNEL';

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
     * @param $key
     * @param YouTubeChannelAdapter $adapter
     */
    public function __construct($key, YouTubeChannelAdapter $adapter)
    {
        $this->key = $key;
        $this->adapter = $adapter;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::EMBED_YOUTUBE_CHANNEL;
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
     * @return array
     */
    public function getItems($page = 1, $limit = 10)
    {
        return $this->adapter->getItems($this->getKey(), $page, $limit);
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        return $this->key;
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
     * @param $key
     * @return mixed
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Refresh data from Google
     */
    public function refresh()
    {
        $this->adapter->refresh($this->getKey());
    }


}
