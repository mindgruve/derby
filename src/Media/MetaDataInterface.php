<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface MetaDataInterface
{

    // Status Flags
    const STATUS_PUBLISHED = 'PUBLISHED';
    const STATUS_UNPUBLISHED = 'UNPUBLISHED';
    const STATUS_TRASHED = 'TRASHED';

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @return \Derby\Media\Collection | null
     */
    public function getParent();

    /**
     * @param MediaInterface $parent
     * @return $this
     */
    public function setParent(MediaInterface $parent);

    /**
     * @return \DateTime
     */
    public function getDateCreated();

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDateCreated(\DateTime $date);

    /**
     * @return \DateTime
     */
    public function getDateModified();

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDateModified(\DateTime $date);

    /**
     * @return string
     */
    public function getFileExtension();

    /**
     * @return string
     */
    public function setFileExtension($extension);

    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @param $mimeType
     * @return $this
     */
    public function setMimeType($mimeType);

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();
}
