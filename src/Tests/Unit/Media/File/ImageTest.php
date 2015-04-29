<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use Derby\Media\Local\Image;
use PHPUnit_Framework_TestCase;
use Mockery;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';
    protected static $abstractImagine = 'Imagine\Image\AbstractImagine';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertEquals(Image::TYPE_MEDIA_FILE_IMAGE, $sut->getMediaType());
    }

}
