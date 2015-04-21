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
}
