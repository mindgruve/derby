<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Adapter;
use Derby\Media\RemoteFile;

/**
 * Derby\Adapter\RemoteFileAdapter
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class RemoteFileAdapter extends AbstractGaufretteAdapter implements RemoteFileAdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getMedia($key)
    {
        return new RemoteFile($key, $this);
    }
}