<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface FileInterface extends MediaInterface
{

    const TYPE_MEDIA_FILE = 'MEDIA\FILE';

    /**
     * @return string
     */
    public function getKey();
    
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
}
