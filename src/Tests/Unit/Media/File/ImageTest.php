<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Image;
use PHPUnit_Framework_TestCase;
use Mockery;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected static $fileClass = 'Derby\Media\File\Image';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Image($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Image($key, $filesystem, $metaData);

        $this->assertEquals(Image::TYPE_MEDIA_FILE_IMAGE, $sut->getMediaType());
    }

}
