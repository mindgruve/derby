<?php

namespace Derby\Media\Alias;

use Derby\Media\Alias;
use Derby\Media\CollectionInterface;
use Derby\Media\MediaInterface;
use Derby\Media\MetaData;
use SplObjectStorage;

class CollectionAlias extends Alias implements CollectionInterface
{

    const TYPE_ALIAS_COLLECTION = 'MEDIA\ALIAS\COLLECTION';

    /**
     * @var CollectionInterface
     */
    protected $target;

    public function __construct(
        CollectionInterface $target,
        MetaData $metaData
    ) {
        $this->target = $target;

        parent::__construct($target, $metaData);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_ALIAS_COLLECTION;
    }

    /**
     * @return CollectionInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param CollectionInterface $collection
     * @return $this
     */
    public function addAll(CollectionInterface $collection)
    {
        $this->target->addAll($collection);

        return $this;
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function attach(MediaInterface $item)
    {
        $this->target->attach($item);

        return $this;
    }

    /**
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains(MediaInterface $item)
    {
        return $this->target->contains($item);
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->target->count();
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->target->current();
    }

    /**
     * @param MediaInterface $item
     * @return $this
     */
    public function detach(MediaInterface $item)
    {
        $this->target->detach($item);

        return $this;
    }

    /**
     * @param $object
     * @return mixed
     */
    public function getHash(MediaInterface $object)
    {
        return $this->target->getHash($object);

    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->target->getInfo();
    }

    /**
     * @return SplObjectStorage
     */
    public function getItems()
    {
        return $this->target->getItems();
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->target->key();
    }

    /**
     *
     */
    public function next()
    {
        $this->target->next();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->target->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed]
     */
    public function offsetGet($offset)
    {
        return $this->target->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->target->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->target->offsetUnset($offset);
    }

    /**
     * @param CollectionInterface $collection
     * @return $this
     */
    public function removeAll(CollectionInterface $collection)
    {
        return $this->target->removeAll($collection);
    }

    /**
     * @param CollectionInterface $collection
     * @return mixed
     */
    public function removeAllExcept(CollectionInterface $collection)
    {
        return $this->target->removeAllExcept($collection);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->target->rewind();
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return $this->target->serialize();
    }

    /**
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->target->unserialize($serialized);
    }

    /**
     * @param $data
     * @return $this
     */
    public function setInfo($data)
    {
        $this->target->setInfo($data);

        return $this;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->target->valid();
    }
}
