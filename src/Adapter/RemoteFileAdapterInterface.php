<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Adapter;

/**
 * Derby\Adapter\RemoteFileAdapterInterface
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface RemoteFileAdapterInterface extends GaufretteAdapterInterface
{
    // may not be needed but we want to hint to remote specifically, not just gaufrette.
    // this is because the local interface will satisfy the gaufrette type hint (if we had that).
}