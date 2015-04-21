<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\MediaInterface;
use Derby\AdapterInterface;

/**
 * Derby\Media\LocalFileInterface
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface LocalFileInterface extends MediaInterface
{
    const TYPE_MEDIA_FILE = 'MEDIA\LOCAL_FILE';

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
     * @param $data
     * @return mixed
     */
    public function write($data);

    /**
     * @return boolean
     */
    public function read();

    /**
     * @return string
     */
    public function getFileExtension();

    /**
     * @param string
     * @return string
     */
    public function setFileExtension($extension);

    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @param $mimeType
     * @return $this
     */
    public function setMimeType($mimeType);

    /**
     * @param AdapterInterface $adapter
     * @return RemoteFileInterface
     */
    public function upload(AdapterInterface $adapter);
}