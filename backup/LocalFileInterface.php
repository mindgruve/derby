<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\MediaInterface;
use Derby\AdapterInterface;

/**
 * Derby\Media\LocalFileAdapterInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface LocalFileInterface extends FileInterface
{
    /**
     * Get file mime/media type
     * @return string
     */
    public function getMimeType();

    /**
     * Get file size
     * @return int|null Size or null if file doesn't exist
     */
    public function getSize();

    /**
     * Get file path
     *
     * @return string
     */
    public function getPath();
}
