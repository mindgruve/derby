<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Adapter;

/**
 * Derby\Adapter\LocalFileAdapterInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
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