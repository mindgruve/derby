<?php

namespace Derby\Media\Embed\YouTube;

use Derby\Exception\NotSupportedByAdapterException;
use Derby\Media\CollectionInterface;
use Derby\MediaInterface;

class YouTubeChannel implements CollectionInterface
{
    const EMBED_YOUTUBE_CHANNEL = 'EMBED/YOUTUBE/CHANNEL';

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::EMBED_YOUTUBE_CHANNEL;
    }

    /**
     * @param MediaInterface $item
     * @return void
     * @throws NotSupportedByAdapterException
     */
    public function attach(MediaInterface $item)
    {
        throw new NotSupportedByAdapterException();
    }

    /**
     * @param array $items
     * @return void
     * @throws NotSupportedByAdapterException
     */
    public function addAll(array $items)
    {
        throw new NotSupportedByAdapterException();
    }

    /**
     * @param MediaInterface $item
     * @return bool
     * @throws NotSupportedByAdapterException
     */
    public function contains(MediaInterface $item)
    {
        if(! $item instanceof YouTubeVideo){
            throw new NotSupportedByAdapterException();
        }


    }


}
