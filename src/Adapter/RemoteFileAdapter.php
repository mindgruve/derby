<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Adapter;
use Derby\Media\RemoteFile;

/**
 * Derby\Adapter\RemoteFileAdapter
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
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