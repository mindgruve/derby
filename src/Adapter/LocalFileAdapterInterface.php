<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Adapter;

/**
 * Derby\Adapter\LocalFileAdapterInterface
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface LocalFileAdapterInterface extends GaufretteAdapterInterface
{
    /**
     * Get base path
     * @return string
     */
    public function getBasePath();

    /**
     * Get full path for a key including the base path
     * @param $key
     * @return mixed
     */
    public function getPath($key);
}