<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Audio;
use PHPUnit_Framework_TestCase;
use Mockery;

class AudioTest extends PHPUnit_Framework_TestCase
{

    protected static $fileClass = 'Derby\Media\File\Audio';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Audio($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Audio($key, $filesystem, $metaData);

        $this->assertEquals(Audio::TYPE_MEDIA_FILE_AUDIO, $sut->getMediaType());
    }
}
