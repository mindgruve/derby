<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Adapter\FileAdapterInterface;
use Derby\Exception\UnknownTransferAdapterException;
use Derby\Media\CollectionInterface;
use Derby\Media\File;
use Derby\Media\FileInterface;
use Derby\Media\SearchInterface;
use Derby\Media\Factory\FactoryInterface;
use Derby\Exception\DerbyException;
use Derby\Adapter\AdapterInterface;

/**
 * Derby\MediaManager
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class MediaManager implements MediaManagerInterface
{
    /**
     * @var array
     */
    protected $factories = [];

    /**
     * @var array
     */
    protected $adapters = [];

    /**
     * @param FactoryInterface $factory
     * @param null $priority
     * @return $this
     */
    public function registerFileFactory(FactoryInterface $factory, $priority = null)
    {
        // set default priority
        if (!$priority) {
            $priority = 10;
        }

        $this->factories[$priority][] = $factory;

        return $this;
    }

    /**
     * @param $adapterKey
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function registerAdapter($adapterKey, AdapterInterface $adapter)
    {
        $this->setAdapter($adapterKey, $adapter);

        return $this;
    }

    /**
     * @param $adapterKey
     * @return $this
     */
    public function unregisterAdapter($adapterKey)
    {
        unset($this->adapters[$adapterKey]);

        return $this;
    }

    /**
     * @param $adapterKey
     * @return AdapterInterface
     * @throws DerbyException
     */
    public function getAdapter($adapterKey)
    {
        if (isset($this->adapters[$adapterKey])) {
            return $this->adapters[$adapterKey];
        }

        throw new DerbyException('Adapter Key Not Found');
    }

    /**
     * @param $adapterKey
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter($adapterKey, AdapterInterface $adapter)
    {
        $this->adapters[$adapterKey] = $adapter;

        return $this;
    }

    /**
     * @param $key
     * @param $adapterKey
     * @return File|MediaInterface
     * @throws DerbyException
     */
    public function getMedia($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);

        if ($adapter instanceof AdapterInterface) {
            $media = $adapter->getMedia($key);
        } else {
            $media = new Media($key, $adapter);
        }

        return $this->convertMedia($media);
    }

    /**
     * @param MediaInterface $media
     * @return File|MediaInterface
     */
    public function convertMedia(MediaInterface $media)
    {
        foreach ($this->factories as $priorityGroup) {
            foreach ($priorityGroup as $factory) {
                /** @var \Derby\Media\Factory\FactoryInterface $factory */
                if ($factory->supports($media)) {
                    return $factory->build($media->getKey(), $media->getAdapter());
                }
            }
        }

        return $media;
    }


    /**
     * @param MediaInterface $media
     * @param $adapterKey
     * @param null $newKey
     * @return FileInterface
     * @throws UnknownTransferAdapterException
     */
    public function transfer(MediaInterface $media, $adapterKey, $newKey = null)
    {
        $adapter = $this->getAdapter($adapterKey);

        if (!$newKey) {
            $newKey = $media->getKey();
        }

        if ($media instanceof FileInterface && $adapter instanceof FileAdapterInterface) {
            $adapter->write($newKey, $media->read());

            return $this->convertMedia(new File($newKey, $adapter));
        } else {
            throw new UnknownTransferAdapterException('Adapter must be file adapter to transfer to.');
        }
    }

    /**
     * @param SearchInterface $search
     * @param AdapterInterface[] $adapters
     * @return MediaInterface
     */
    public function findMedia(SearchInterface $search, array $adapters)
    {
        // TODO: Implement findMedia() method.
    }

    /**
     * @param $key
     * @param $adapterKey
     * @return boolean
     */
    public function exists($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);

        return $adapter->exists($key);
    }
}
