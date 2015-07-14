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
     * @param AdapterInterface $adapter
     * @return MediaInterface
     */
    public function getMedia($key, AdapterInterface $adapter);

    /**
     * @param SearchInterface $search
     * @param AdapterInterface[] $adapters
     * @return mixed
     */
    public function findMedia(SearchInterface $search, array $adapters);
    
    /**
     * @param $key
     * @param AdapterInterface $adapter
     * @return bool
     */
    public function exists($key, AdapterInterface $adapter);
    
}
