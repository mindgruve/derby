<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Media\SearchInterface;

/**
 * Derby\ManagerInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface MediaManagerInterface
{
    /**
     * @param $key
     * @param $adapterKey
     * @return mixed
     */
    public function getMedia($key, $adapterKey);

    /**
     * @param SearchInterface $search
     * @param AdapterInterface[] $adapters
     * @return mixed
     */
    public function findMedia(SearchInterface $search, array $adapters);

    /**
     * @param $key
     * @param $adapterKey
     * @return mixed
     */
    public function exists($key, $adapterKey);

    /**
     * @param $key
     * @param $adapterKey
     * @param null $data
     * @return mixed
     */
    public function buildFile($key, $adapterKey, $data = null);

    /**
     * @param MediaInterface $media
     * @param $adapterKey
     * @param null $newKey
     * @return MediaInterface
     */
    public function transfer(MediaInterface $media, $adapterKey, $newKey = null);
    
}
