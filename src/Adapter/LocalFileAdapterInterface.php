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
     * @param string $baseDirectory Base directory where file is located
     * @param bool $create Do we create directory
     * @param int $mode Directory permissions
     */
    public function __construct($baseDirectory, $create = false, $mode = 0777);

    /**
     * Get base directory
     * @return string
     */
    public function getBaseDirectory();
}