<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use Derby\Media\Local\Image;
use PHPUnit_Framework_TestCase;
use Mockery;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Image($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Image($key, $adapter);

        $this->assertEquals(Image::TYPE_MEDIA_FILE_IMAGE, $sut->getMediaType());
    }

}
