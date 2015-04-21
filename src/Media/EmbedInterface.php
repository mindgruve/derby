<?php

namespace Derby\Media;

use Derby\MediaInterface;

interface EmbedInterface extends MediaInterface
{
    const TYPE_MEDIA_EMBED = 'MEDIA\EMBED';

    /**
     * Returns the embed HTML
     * @param array $options
     * @return mixed
     */
    public function render(array $options = array());
}
