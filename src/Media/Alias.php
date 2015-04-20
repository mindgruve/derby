<?php

namespace Derby\Media;

use Derby\FileSystem;
use Derby\MediaInterface;

class Alias extends Media implements AliasInterface
{

    /**
     * @var MediaInterface
     */
    protected $target;

    public function __construct(
        MediaInterface $target,
        MetaData $metaData
    ) {
        $this->target   = $target;

        parent::__construct($metaData);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_ALIAS;
    }

    /**
     * @return MediaInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

}
