<?php

namespace Derby\Tests\Unit\File;

use PHPUnit_Framework_TestCase;
use Derby\Media\LocalFile;
use Derby\Media\LocalFile\Video;
use Mockery;

class VideoTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Video($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Video($key, $adapter);

        $this->assertEquals(Video::TYPE_MEDIA_FILE_VIDEO, $sut->getMediaType());
    }
}
