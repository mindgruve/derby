<?php

namespace Derby\Media;

use Derby\AccessControl\Permissions;
use Derby\MediaInterface;

class MetaData implements MetaDataInterface
{

    /**
     * @var string
     */
    protected $label;

    /**
     * @var MediaInterface | null
     */
    protected $parent;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     */
    protected $dateModified;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var Permissions
     */
    protected $permissions;

    public function __construct(
        $label,
        $status,
        Permissions $permissions,
        MediaInterface $parent = null,
        $dateCreated = null,
        $dateModified = null,
        $extension = null,
        $mimeType = null
    ) {
        $this->label       = $label;
        $this->permissions = $permissions;
        $this->parent      = $parent;

        $this->dateCreated = $dateCreated;
        if (!$dateCreated) {
            $this->dateCreated = new \DateTime();
        }

        $this->dateModified = $dateModified;
        if (!$this->dateModified) {
            $this->dateModified = new \DateTime();
        }

        $this->extension = $extension;
        $this->mimeType  = $mimeType;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return MediaInterface | null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(MediaInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDateCreated(\DateTime $date)
    {
        $this->dateCreated = $date;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDateModified(\DateTime $date)
    {
        $this->dateModified = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function setFileExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * @param $mimeType
     * @return $this
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function setPermissions(Permissions $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getPermissions(Permissions $permissions)
    {
        return $this->permissions;
    }

}
