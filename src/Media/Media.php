<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\FileAdapter;
use Derby\Adapter\AdapterInterface;

/**
 * Derby\MediaInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class Media implements MediaInterface
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $mediaKey;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param $mediaKey
     * @param AdapterInterface $adapter
     */
    public function __construct($mediaKey, AdapterInterface $adapter)
    {
        $this->setKey($mediaKey);
        $this->setAdapter($adapter);
    }

    /**
     * @return FileAdapter
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
        return $this->mediaKey;
    }

    /**
     * Set key
     * @param $mediaKey
     * @return mixed
     */
    public function setKey($mediaKey)
    {
        $this->mediaKey = $mediaKey;
    }

    public function exists()
    {
        return $this->adapter->exists($this->mediaKey);
    }
}
