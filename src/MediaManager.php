<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Adapter\EmbedAdapterInterface;
use Derby\Adapter\FileAdapterInterface;
use Derby\Exception\UnknownTransferAdapterException;
use Derby\Media\Collection;
use Derby\Media\CollectionInterface;
use Derby\Media\Embed;
use Derby\Media\EmbedInterface;
use Derby\Media\File;
use Derby\Media\FileInterface;
use Derby\Media\LocalFile;
use Derby\Media\SearchInterface;
use Derby\Media\File\Factory\FactoryInterface;

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
    protected $fileFactories = [];

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

        $this->fileFactories[$priority][] = $factory;

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
     * @throws \Exception
     */
    public function getAdapter($adapterKey)
    {
        if (isset($this->adapters[$adapterKey])) {
            return $this->adapters[$adapterKey];
        }

        throw new \Exception('Adapter Key Not Found');
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
     * @return MediaInterface|CollectionInterface|EmbedInterface|FileInterface
     * @throws \Exception
     */
    public function getMedia($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);

        if ($adapter instanceof FileAdapterInterface) {
            $media = $this->getFile($key, $adapterKey);
        } elseif ($adapter instanceof CollectionAdapterInterface) {
            $media = $this->getCollection($key, $adapterKey);
        } elseif ($adapter instanceof EmbedAdapterInterface) {
            $media = $this->getEmbed($key, $adapterKey);
        } else {
            $media = new Media($key, $adapter);
        }

        return $media;
    }

    /**
     * @param $key
     * @param $adapterKey
     * @return FileInterface
     * @throws \Exception
     */
    public function getFile($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);
        $file = $adapter->getMedia($key);

        if (!$adapter instanceof FileAdapterInterface) {
            throw new \Exception('Adapter not of type FileAdapterInterface');
        }

        if (!$file) {
            $file = new File($key, $adapter);
        }

        return $this->convertFile($file);
    }

    /**
     * @param $key
     * @param $adapterKey
     * @return EmbedInterface
     * @throws \Exception
     */
    public function getEmbed($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);
        $embed = $adapter->getMedia($key);

        if (!$adapter instanceof EmbedAdapterInterface) {
            throw new \Exception('Adapter not of type EmbedAdapterInterface');
        }

        if (!$embed) {
            $embed = new Embed($key, $adapter);
        }

        return $this->convertEmbed($embed);
    }

    /**
     * @param $key
     * @param $adapterKey
     * @return CollectionInterface
     * @throws \Exception
     */
    public function getCollection($key, $adapterKey)
    {
        $adapter = $this->getAdapter($adapterKey);

        if (!$adapter instanceof CollectionAdapterInterface) {
            throw new \Exception('Adapter not of type CollectionAdapterInterface');
        }

        $collection = $adapter->getMedia($key);

        if (!$collection) {
            $collection = new Collection($key, $adapter);
        }

        return $this->convertCollection($collection);
    }

    /**
     * @param FileInterface $file
     * @return FileInterface
     */
    public function convertFile(FileInterface $file)
    {
        foreach ($this->fileFactories as $priorityGroup) {
            foreach ($priorityGroup as $fileFactory) {
                /** @var \Derby\Media\File\Factory\FileFactory $fileFactory */
                if ($fileFactory->supports($file)) {
                    return $fileFactory->build($file->getKey(), $file->getAdapter());
                }
            }
        }

        return $file;
    }

    /**
     * @param EmbedInterface $embed
     * @return EmbedInterface
     */
    public function convertEmbed(EmbedInterface $embed)
    {
        return $embed;
    }

    /**
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function convertCollection(CollectionInterface $collection)
    {
        return $collection;
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
            return $this->convertFile(new File($newKey, $adapter));
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
