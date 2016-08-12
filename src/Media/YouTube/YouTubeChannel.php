<?php

namespace Derby\Media\YouTube;

use Derby\Adapter\Embed\YouTubeChannelAdapter;
use Derby\AdapterInterface;
use Derby\Exception\NotSupportedByAdapterException;
use Derby\Media\CollectionInterface;
use Derby\MediaInterface;

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
        // TODO: Implement contains() method.
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @return boolean
     */
    public function exists()
    {
        // TODO: Implement exists() method.
    }

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        // TODO: Implement getAdapter() method.
    }

    /**
     * @return array
     */
    public function getItems($page = 1, $limit = 10)
    {

    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        // TODO: Implement getKey() method.
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
     * Set adapter
     * @param AdapterInterface $adapterInterface
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapterInterface)
    {
        // TODO: Implement setAdapter() method.
    }

    /**
     * Set key
     * @param $key
     * @return mixed
     */
    public function setKey($key)
    {
        // TODO: Implement setKey() method.
    }


}
