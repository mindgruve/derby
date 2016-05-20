<?php

namespace Derby\Media\Embed\YouTube;

use Derby\Media\Embed;

class YouTubeVideo extends Embed
{

    const TYPE_MEDIA_EMBED_YOUTUBE = 'MEDIA/EMBED/YOUTUBE';

    public function getMediaType()
    {
        return self::TYPE_MEDIA_EMBED_YOUTUBE;
    }


}
