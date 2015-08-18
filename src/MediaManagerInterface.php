<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Media\SearchInterface;
use Derby\Media\File\Factory\FactoryInterface;
use Derby\Media\CollectionInterface;
use Derby\Media\EmbedInterface;
use Derby\Media\FileInterface;
use Derby\Media\File;

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
     * @throws \Exception
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
     * @return MediaInterface|CollectionInterface|EmbedInterface|FileInterface
     * @throws \Exception
     */
    public function getMedia($key, $adapterKey);

    /**
     * @param $key
     * @param $adapterKey
     * @return FileInterface
     * @throws \Exception
     */
    public function getFile($key, $adapterKey);

    /**
     * @param $key
     * @param $adapterKey
     * @return EmbedInterface
     * @throws \Exception
     */
    public function getEmbed($key, $adapterKey);

    /**
     * @param $key
     * @param $adapterKey
     * @return CollectionInterface
     * @throws \Exception
     */
    public function getCollection($key, $adapterKey);

    /**
     * @param FileInterface $file
     * @return FileInterface
     */
    public function convertFile(FileInterface $file);

    /**
     * @param EmbedInterface $embed
     * @return EmbedInterface
     */
    public function convertEmbed(EmbedInterface $embed);

    /**
     * @param CollectionInterface $collection
     * @return CollectionInterface
     */
    public function convertCollection(CollectionInterface $collection);


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