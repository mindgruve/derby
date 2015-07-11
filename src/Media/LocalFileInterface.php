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
interface LocalFileInterface extends MediaInterface
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
     * Indicates whether the file exists
     * @return boolean
     */
    public function exists();

    /**
     * Delete file
     * @return boolean
     */
    public function delete();

    /**
     * Rename/move file
     *
     * Note that the new file path will always be relative to the base directory of
     * the injected {@see LocalFileAdapterInterface} due to how gaufrette "file systems" work.
     *
     * The reason the above feels like a leaky abstraction is because it is! This is partially due
     * to interface inheritance behavior. We cannot enforce that the injected adapter will be local
     * but it should be implied by your implementation. @todo We can refactor where needed.
     *
     * @param $newKey
     * @return boolean
     */
    public function rename($newKey);

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
