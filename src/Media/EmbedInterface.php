<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface EmbedInterface extends MediaInterface
{
    /**
     * Returns the embed HTML
     * @param array $options
     * @return mixed
     */
    public function render(array $options = array());
}
