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
use Derby\Media\MediaInterface;

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
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function registerAdapter(AdapterInterface $adapter);

    /**
     *  @param AdapterInterface $adapter
     * @return $this
     */
    public function unregisterAdapter(AdapterInterface $adapter);

    /**
     * @param $adapterKey
     * @return AdapterInterface
     * @throws DerbyException
     */
    public function getAdapter($adapterKey);

    /**
     * @param $adapterKey
     * @param $mediaKey
     * @return mixed
     */
    public function getMedia($adapterKey,$mediaKey);

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
    public function search(SearchInterface $search, array $adapters);

    /**
     * @param $mediaKey
     * @param $adapterKey
     * @return boolean
     */
    public function exists($mediaKey, $adapterKey);

}
