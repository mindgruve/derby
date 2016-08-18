<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby;

use Derby\Adapter\AdapterInterface;

/**
 * Derby\MediaInterface
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
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

    /**
     * @return boolean
     */
    public function exists();
}
