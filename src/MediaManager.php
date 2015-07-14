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
use Derby\Media\LocalFile;
use Derby\Media\LocalFileInterface;
use Derby\Media\SearchInterface;
use Derby\Media\File\FactoryInterface;
use Mockery\CountValidator\Exception;

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
     * @param int $priority
     */
    public function registerFileFactory(FactoryInterface $factory, $priority = null)
    {
        // set default priority
        if (!$priority) {
            $priority = 10;
        }

        $this->fileFactories[$priority][] = $factory;
    }

    /**
     * @param AdapterInterface $adapter
     * @param $adapterKey
     */
    public function registerAdapter(AdapterInterface $adapter, $adapterKey)
    {
        $this->setAdapter($adapter, $adapterKey);
    }

    /**
     * @param $adapterKey
     */
    public function unregisterAdapter($adapterKey)
    {
        unset($this->adapters[$adapterKey]);
    }

    /**
     * @param $adapterKey
     * @return \Derby\AdapterInterface
     */
    public function getAdapter($adapterKey)
    {
        if (isset($this->adapters[$adapterKey])) {
            return $this->adapters[$adapterKey];
        }

        throw new Exception('Adapter Key Not Found');
    }

    /**
     * @param AdapterInterface $adapter
     * @param $adapterKey
     */
    public function setAdapter(AdapterInterface $adapter, $adapterKey)
    {
        $this->adapters[$adapterKey] = $adapter;
    }


    /**
     * @param $key
     * @param FileAdapterInterface $adapter
     * @param null $data
     * @return LocalFileInterface|mixed
     */
    public function buildFile($key, FileAdapterInterface $adapter, $data = null)
    {
        $local = new File($key, $adapter);

        if ($data) {
            $local->write($data);
        }

        return $this->convertFile($local);
    }

    /**
     * @param $key
     * @param AdapterInterface $adapter
     * @return MediaInterface
     */
    public function getMedia($key, AdapterInterface $adapter)
    {
        $media = $adapter->getMedia($key);

        if (!$media->exists()) {
            return null;
        }

        if ($media instanceof File) {
            $media = $this->convertFile($media);
        }

        return $media;
    }

    /**
     * @param FileInterface $file
     * @return FileInterface
     */
    public function convertFile(FileInterface $file)
    {
        foreach ($this->fileFactories as $priorityGroup) {
            foreach ($priorityGroup as $fileFactory) {
                /** @var \Derby\Media\File\FileFactory $fileFactory */
                if ($fileFactory->supports($file)) {
                    return $fileFactory->build($file->getKey(), $file->getAdapter());
                }
            }
        }

        return $file;
    }

    public function transfer(MediaInterface $media, AdapterInterface $adapter, $newKey = null)
    {
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
     * @return mixed
     */
    public function findMedia(SearchInterface $search, array $adapters)
    {
        // TODO: Implement findMedia() method.
    }

    /**
     * @param $key
     * @param AdapterInterface $adapter
     * @return bool
     */
    public function exists($key, AdapterInterface $adapter)
    {
        return $adapter->exists($key);
    }
}
