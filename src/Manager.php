<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;
use Derby\Media\SearchInterface;

/**
 * Derby\Manager
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class Manager implements ManagerInterface
{
    /**
     * @param $key
     * @param AdapterInterface $adapter
     * @return MediaInterface
     */
    public function getMedia($key, AdapterInterface $adapter)
    {
        // @todo Actual implementation
        return $adapter->getMedia($key);
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
        // TODO: Implement exists() method.
    }
}