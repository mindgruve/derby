<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\MediaInterface;

/**
 * Derby\Media\ReadOnlyRemoteFileInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
interface ReadOnlyRemoteFileInterface extends MediaInterface
{
    /**
     * Read data from file
     * @return string|boolean if cannot read content
     */
    public function read();

    /**
     * Indicates whether the file exists
     * @return boolean
     */
    public function exists();

    /**
     * Get full URL to file
     * @return string
     */
    public function getUrl();

    /**
     * Get extension
     * @return string
     */
    public function getFileExtension();
}