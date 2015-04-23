<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;

/**
 * Derby\MediaInterface
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
abstract class Media implements MediaInterface
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param $key
     * @param AdapterInterface $adapter
     */
    public function __construct($key, AdapterInterface $adapter)
    {
        $this->setKey($key);
        $this->setAdapter($adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set adapter
     * @param AdapterInterface $adapter
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return $this->key;
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
}
