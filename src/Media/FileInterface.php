<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface FileInterface extends MediaInterface
{

    /**
     * Read data from file
     * @return string|boolean if cannot read content
     */
    public function read();

    /**
     * Write data to file
     * @param $data
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function write($data);

    /**
     * Delete file
     * @return boolean
     */
    public function delete();

    /**
     * Rename/move file
     *
     * @param $newKey
     * @return boolean
     */
    public function rename($newKey);

    /**
     * @param $newKey
     * @return mixed
     */
    public function copy($newKey);

    /**
     * @param string $key
     * @param null $directory
     * @return LocalFile
     */
    public function copyToLocal($key, $directory = null);

}