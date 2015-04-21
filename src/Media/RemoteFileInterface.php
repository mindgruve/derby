<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\MediaInterface;

/**
 * Derby\Media\RemoteFileInterface
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface RemoteFileInterface extends MediaInterface
{
    const TYPE_MEDIA_FILE = 'MEDIA\REMOTE_FILE';

    /**
     * @return bool
     */
    public function remove();

    /**
     * @param $newKey
     * @return mixed
     */
    public function rename($newKey);

    /**
     * @return LocalFileInterface
     */
    public function download();

    /**
     * @return string
     */
    public function getFileExtension();

    /**
     * @param string
     * @return string
     */
    public function setFileExtension($extension);

}