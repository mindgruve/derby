<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;

use Symfony\Component\Finder\Adapter\AdapterInterface;

/**
 * Derby\MediaInterface
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 * @todo Remove idea of meta data, All meta data methods should live here or in child.
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
     * @return \Derby\Media\MetaData
     * @todo Remove idea of meta data, All meta data methods should live here or in child.
     */
    public function getMetaData();

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
     * Save media
     * @return bool
     */
    public function save();

    /**
     * Delete media
     * @return bool
     */
    public function delete();
}
