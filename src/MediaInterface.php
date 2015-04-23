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
     * Set adapter
     * @param AdapterInterface $adapterInterface
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapterInterface);

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * Set key
     * @param $key
     * @return mixed
     */
    public function setKey($key);

    /**
     * Get key
     * @return string
     */
    public function getKey();
}
