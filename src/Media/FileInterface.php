<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface FileInterface extends MediaInterface
{

    const TYPE_MEDIA_FILE = 'MEDIA\FILE';

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
}
