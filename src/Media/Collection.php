<?php

namespace Derby\Media;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Media;
use Derby\MediaInterface;

class Collection extends Media implements CollectionInterface
{

    const MEDIA_COLLECTION = 'MEDIA/COLLECTION';

    /**
     * @var string
     */
    protected $key;

    /**
     * @var CollectionAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $items = array();

    /**
     * @param $key
     * @param CollectionAdapterInterface $adapter
     * @param array $items
     */
    public function __construct(
        $key,
        CollectionAdapterInterface $adapter,
        array $items = array()
    ) {
        $this->key = $key;
        $this->adapter = $adapter;
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::MEDIA_COLLECTION;
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function add(MediaInterface $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item)
    {
        return in_array($item, $this->items);
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function remove(MediaInterface $item)
    {
        $indexes = array_keys($this->items, $item);
        foreach ($indexes as $index) {
            unset($this->items[$index]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getItems($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $length = $limit;

        return array_slice($this->items, $offset, $length);
    }


    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
