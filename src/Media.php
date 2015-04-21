<?php

namespace Derby;

class Media implements MediaInterface
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @var \DateTime
     */
    protected $dateModified;

    public function __construct(
        $key,
        AdapterInterface $adapter
    ) {
        $this->key     = $key;
        $this->adapter = $adapter;
    }

    public function getMediaType()
    {
        return self::TYPE_MEDIA;
    }

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set adapter
     * @param AdapterInterface $adapter
     * @return mixed
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key
     * @param $key
     * @return MediaInterface
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @param \DateTime $dateCreated
     * @return $this
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
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
     * @param \DateTime $dateModified
     * @return $this
     */
    public function setDateModified(\DateTime $dateModified)
    {
        $this->dateModified = $dateModified;
        return $this;
    }

    /**
     * @return \Derby\Media\Group | null
     */
    public function getParent()
    {
        // TODO: Implement getParent() method.
    }

    /**
     * @param MediaInterface $parent
     * @return $this
     */
    public function setParent(MediaInterface $parent)
    {
        // TODO: Implement setParent() method.
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        // TODO: Implement setStatus() method.
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }
}
