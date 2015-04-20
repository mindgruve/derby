<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface EmbedInterface extends MediaInterface
{
    const TYPE_MEDIA_EMBED = 'MEDIA\EMBED';

    /**
     * Replaces the options array
     * @param array $options
     * @return mixed
     */
    public function setOptions(array $options = array());

    /**
     * Returns the options array needed to build the embed HTML
     * @return array
     */
    public function getOptions();

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setOption($key, $value);

    /**
     * @param $key
     * @return mixed
     */
    public function getOption($key);
    
    /**
     * Returns the embed HTML
     * @return string
     */
    public function render();
}
