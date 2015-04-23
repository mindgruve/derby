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
 * Derby\Media\LocalFileAdapterInterface
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface LocalFileInterface extends MediaInterface
{
    const TYPE_MEDIA_FILE = 'MEDIA\LOCAL_FILE';

    /**
     * Delete file
     * @return bool
     */
    public function delete();

    /**
     * Rename/move file
     * @param $newKey
     * @return mixed
     */
    public function rename($newKey);

    /**
     * Write data to file
     * @param $data
     * @return mixed
     */
    public function write($data);

    /**
     * Read data from file
     * @return boolean
     */
    public function read();

    /**
     * Upload file
     * @param AdapterInterface $adapter
     * @return RemoteFileInterface
     */
    public function upload(AdapterInterface $adapter);

    /**
     * Get file extension
     * @return string
     */
    public function getFileExtension();

    /**
     * Get file mime/media type
     * @return string
     */
    public function getMimeType();

    /**
     * Get file path
     * @return string
     */
    public function getPath();
}