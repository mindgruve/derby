<?php

namespace Derby\Tests\Unit\File;

use PHPUnit_Framework_TestCase;
use Derby\Media\File;
use Derby\Media\File\Video;
use Mockery;

class VideoTest extends PHPUnit_Framework_TestCase
{

    protected static $fileClass = 'Derby\Media\File\Video';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Video($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Video($key, $filesystem, $metaData);

        $this->assertEquals(Video::TYPE_MEDIA_FILE_VIDEO, $sut->getMediaType());
    }
}
