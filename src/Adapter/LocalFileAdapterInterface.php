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
     * Get base directory
     * @return string
     */
    public function getBaseDirectory();
}