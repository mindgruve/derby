<?php

namespace Derby\Media;

use Derby\Adapter\EmbedAdapterInterface;
use Derby\Media;

class Embed extends Media implements EmbedInterface
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var EmbedAdapterInterface
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $options;

    public function __construct(
        $key,
        EmbedAdapterInterface $adapter,
        array $options = array()
    ) {
        $this->key     = $key;
        $this->adapter = $adapter;
        $this->options = $options;
    }


    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_EMBED;
    }

    /**
     * Returns the embed HTML
     * @return string
     */
    public function render(array $options = array())
    {
        return $this->adapter->render($this->getKey());
    }
}
