<?php

namespace Derby\Media\Image;

use PHPUnit_Framework_TestCase;
use Imagine\Image\ImageInterface;
use Mockery;
use Derby\Transform\ImageTransform;

class ImageTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertEquals(ImageInterface::THUMBNAIL_INSET, ImageTransform::THUMBNAIL_INSET);
        $this->assertEquals(ImageInterface::THUMBNAIL_OUTBOUND, ImageTransform::THUMBNAIL_OUTBOUND);
    }

}
