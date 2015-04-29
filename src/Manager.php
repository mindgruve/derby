<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Media\Factory\LocalFileFactory;
use Derby\Media\LocalFile;
use Derby\Media\LocalFileInterface;
use Derby\Media\RemoteFile;
use Derby\Media\SearchInterface;

/**
 * Derby\Manager
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class Manager implements ManagerInterface
{
    /**
     * @var Config
     */
    protected $config;
    protected $fileFactories;

    /**
     * @param Config $config
     */
    public function __construct(Config $config = null)
    {
        $this->config        = $config;
        $this->fileFactories = array();
    }

    /**
     * @param array $extensions
     * @param array $mimeTypes
     * @param $callable
     */
    public function registerFile(array $extensions, array $mimeTypes, $callable, $priority = 10)
    {
        $this->fileFactories[$priority][] = new LocalFileFactory($extensions, $mimeTypes, $callable);
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
                /** @var LocalFileFactory $fileFactory */
                if ($fileFactory->supports($file)) {
                    return $fileFactory->build($file->getKey(), $file->getAdapter());
                }
            }
        }

        return $file;
    }

    /**
     * @param RemoteFile $file
     * @param LocalFileAdapterInterface $localAdapter
     * @return LocalFileInterface
     */
    public function downloadFile(RemoteFile $file, LocalFileAdapterInterface $localAdapter)
    {
        $local = $this->convertFile(new LocalFile($file->getKey(), $localAdapter));
        $local->write($file->read());

        return $local;
    }

    /**
     * @param LocalFile $file
     * @param RemoteFileAdapterInterface $adapter
     * @return RemoteFile
     */
    public function uploadFile(LocalFile $file, RemoteFileAdapterInterface $adapter)
    {
        $remote = new RemoteFile($file->getKey(), $adapter);
        $remote->write($file->read());

        return $remote;
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
