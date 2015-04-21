<?php

namespace Derby\Media\Alias;

use Derby\Media\EmbedInterface;
use Derby\Media\Alias;
use Derby\Media\MetaData;

class EmbedAlias extends Alias implements EmbedInterface
{
    const TYPE_MEDIA_ALIAS_EMBED = 'MEDIA\ALIAS\EMBED';

    /**
     * @var EmbedInterface
     */
    protected $target;

    /**
     * @var MetaData
     */
    protected $metaData;

    public function __construct(
        EmbedInterface $target,
        MetaData $metaData
    ) {
        $this->target   = $target;
        $this->metaData = $metaData;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_ALIAS_EMBED;
    }


    /**
     * @param $key
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->target->getOption($key);
    }

    /**
     * Returns the options array needed to build the embed HTML
     * @return array
     */
    public function getOptions()
    {
        return $this->target->getOptions();
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->target->setOption($key, $value);

        return $this;
    }

    /**
     * Replaces the options array
     * @param array $options
     * @return mixed
     */
    public function setOptions(array $options = array())
    {
        $this->target->setOptions($options);

        return $this;
    }

    /**
     * Returns the embed HTML
     * @return string
     */
    public function render()
    {
        return $this->target->render();
    }
}
