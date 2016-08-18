<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\FileAdapterInterface;
use Derby\Exception\UnknownTransferAdapterException;
use Derby\Media\File;
use Derby\Media\FileInterface;
use Derby\Media\SearchInterface;
use Derby\Media\Factory\FactoryInterface;
use Derby\Exception\DerbyException;
use Derby\Adapter\AdapterInterface;
use Derby\Media\MediaInterface;
use Derby\Media\Media;

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
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function registerAdapter(AdapterInterface $adapter)
    {
        $this->adapters[$adapter->getAdapterKey()] = $adapter;

        return $this;
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function unregisterAdapter(AdapterInterface $adapter)
    {
        unset($this->adapters[$adapter->getAdapterKey()]);

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

        throw new DerbyException('Adapter Key Not Found - '.$adapterKey);
    }

    /**
     * @param $adapterKey
     * @param $mediaKey
     * @return File|MediaInterface
     * @throws DerbyException
     */
    public function getMedia($adapterKey, $mediaKey)
    {
        $adapter = $this->getAdapter($adapterKey);

        if ($adapter instanceof AdapterInterface) {
            $media = $adapter->getMedia($mediaKey);
        } else {
            $media = new Media($mediaKey, $adapter);
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
    public function search(SearchInterface $search, array $adapters)
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
