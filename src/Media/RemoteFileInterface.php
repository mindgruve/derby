<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapter;
use Derby\MediaInterface;

/**
 * Derby\Media\RemoteFileInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface RemoteFileInterface extends MediaInterface
{
    const TYPE_MEDIA_REMOTE_FILE = 'MEDIA\REMOTE_FILE';

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
     * @param $newKey
     * @return boolean
     */
    public function rename($newKey);

    /**
     * @param string|null $key
     * @param LocalFileAdapter|null $adapter
     * @return LocalFileInterface
     */
    public function download($key = null, LocalFileAdapter $adapter = null);
}
