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

//    /**
//     * @return string
//     */
//    public function getLabel();
//
//    /**
//     * @param $label
//     * @return $this
//     */
//    public function setLabel($label);
//
//    /**
//     * @return \Derby\Media\Collection | null
//     */
//    public function getParent();
//
//    /**
//     * @param MediaInterface $parent
//     * @return $this
//     */
//    public function setParent(MediaInterface $parent);
//
//    /**
//     * @return \DateTime
//     */
//    public function getDateCreated();
//
//    /**
//     * @param \DateTime $date
//     * @return $this
//     */
//    public function setDateCreated(\DateTime $date);
//
//    /**
//     * @return \DateTime
//     */
//    public function getDateModified();
//
//    /**
//     * @param \DateTime $date
//     * @return $this
//     */
//    public function setDateModified(\DateTime $date);
//
//    /**
//     * @param $status
//     * @return $this
//     */
//    public function setStatus($status);
//
//    /**
//     * @return string
//     */
//    public function getStatus();
}
