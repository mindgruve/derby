<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;

/**
 * Derby\MediaInterface
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
interface MediaInterface
{

    // Object Type
    const TYPE_MEDIA = 'MEDIA';

    /**
     * @return string
     */
    public function getMediaType();

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * Set adapter
     * @param AdapterInterface $adapter
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * Set key
     * @param $key
     * @return MediaInterface
     */
    public function setKey($key);

    /**
     * Get key
     * @return string
     */
    public function getKey();
}
