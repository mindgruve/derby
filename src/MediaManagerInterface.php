<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Media\SearchInterface;
use Derby\Media\Factory\FactoryInterface;
use Derby\Media\CollectionInterface;
use Derby\Media\FileInterface;
use Derby\Media\File;
use Derby\Exception\DerbyException;
use Derby\Adapter\AdapterInterface;

/**
 * Derby\ManagerInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface MediaManagerInterface
{
    /**
     * @param FactoryInterface $factory
     * @param null $priority
     * @return $this
     */
    public function registerFileFactory(FactoryInterface $factory, $priority = null);

    /**
     * @param $adapterKey
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function registerAdapter($adapterKey, AdapterInterface $adapter);

    /**
     * @param $adapterKey
     * @return $this
     */
    public function unregisterAdapter($adapterKey);

    /**
     * @param $adapterKey
     * @return AdapterInterface
     * @throws DerbyException
     */
    public function getAdapter($adapterKey);

    /**
     * @param $adapterKey
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter($adapterKey, AdapterInterface $adapter);

    /**
     * @param $key
     * @param $adapterKey
     * @return MediaInterface|CollectionInterface|AdapterInterface|FileInterface
     * @throws DerbyException
     */
    public function getMedia($key, $adapterKey);

    /**
     * @param MediaInterface $media
     * @param $adapterKey
     * @param null $newKey
     * @return FileInterface
     */
    public function transfer(MediaInterface $media, $adapterKey, $newKey = null);

    /**
     * @param SearchInterface $search
     * @param AdapterInterface[] $adapters
     * @return mixed
     */
    public function findMedia(SearchInterface $search, array $adapters);

    /**
     * @param $key
     * @param $adapterKey
     * @return boolean
     */
    public function exists($key, $adapterKey);

}
