<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\GaufretteAdapterInterface;
use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Exception\UnknownTransferAdapterException;
use Derby\Media\LocalFile;
use Derby\Media\LocalFileInterface;
use Derby\Media\RemoteFile;
use Derby\Media\SearchInterface;
use Derby\Media\LocalFile\FactoryInterface;
use Mockery\CountValidator\Exception;

/**
 * Derby\Manager
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class Manager implements ManagerInterface
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
     * @return mixed
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
     * @param LocalFileAdapterInterface $adapter
     * @param null $data
     * @return LocalFileInterface|mixed
     */
    public function buildFile($key, LocalFileAdapterInterface $adapter, $data = null)
    {
        $local = new LocalFile($key, $adapter);

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

        if ($media instanceof LocalFile) {
            $media = $this->convertFile($media);
        }

        return $media;
    }

    /**
     * @param LocalFileInterface $file
     * @return LocalFileInterface|mixed
     */
    public function convertFile(LocalFileInterface $file)
    {
        foreach ($this->fileFactories as $priorityGroup) {
            foreach ($priorityGroup as $fileFactory) {
                /** @var \Derby\Media\AbstractLocalFileFactory $fileFactory */
                if ($fileFactory->supports($file)) {
                    return $fileFactory->build($file->getKey(), $file->getAdapter());
                }
            }
        }

        return $file;
    }

    /**
     * Transfer the file to another adapter
     *
     * Note that you will receive a different file object depending on whether you're sending to a
     * local or remote file adapter. This will not be the same file object you passed in. You will
     * have 2 independent objects.
     *
     * @param MediaInterface $file The file
     * @param GaufretteAdapterInterface $adapter A gaufrette adapter
     * @param string $key File key (name) used in place of the file being transferred. Useful for overriding the default
     * @return LocalFileInterface|RemoteFileInterface The file object returned depends on the type of gaufrette adapter you're transferring to.
     * @throws UnknownTransferAdapterException When adapter is not a local or remote adapter
     */
    public function transfer(MediaInterface $file, GaufretteAdapterInterface $adapter, $key = null)
    {
        if ($adapter instanceof LocalFileAdapterInterface) {
            $local = new LocalFile($key ?: $file->getKey(), $adapter);
            $local->write($file->read());
            $local = $this->convertFile($local);

            return $local;
        } elseif ($adapter instanceof RemoteFileAdapterInterface) {
            $remote = new RemoteFile($key ?: $file->getKey(), $adapter);
            $remote->write($file->read());

            return $remote;
        } else {
            throw new UnknownTransferAdapterException('Adapter must be a local or remote file adapter to transfer to.');
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
