<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Adapter;

use Derby\MediaInterface;
use Derby\Media\ReadOnlyRemoteFile;

/**
 * Derby\Adapter\ReadOnlyRemoteFileAdapter
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ReadOnlyRemoteFileAdapter implements ReadOnlyRemoteFileAdapterInterface
{
    const ADAPTER_TYPE_READ_ONLY_REMOTE_FILE = 'ADAPTER\READ_ONLY\REMOTE';

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_TYPE_READ_ONLY_REMOTE_FILE;
    }

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key)
    {
        return new ReadOnlyRemoteFile($key, $this);
    }
}