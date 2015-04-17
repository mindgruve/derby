<?php

namespace Derby\Media;

class Embed extends Media implements EmbedInterface
{

    /**
     * @var array
     */
    protected $options;


    public function __construct(
        array $options,
        MetaData $metaData
    ) {
        $this->options  = $options;

        parent::__construct($metaData);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_EMBED;
    }
    
    /**
     * Replaces the options array
     * @param array $options
     * @return mixed
     */
    public function setOptions(array $options = array())
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Returns the options array needed to build the embed HTML
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getOption($key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        return null;
    }

    /**
     * Returns the embed HTML
     * @return string
     */
    public function render()
    {
        return '';
    }
}
