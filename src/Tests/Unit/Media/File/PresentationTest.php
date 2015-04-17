<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Presentation;
use PHPUnit_Framework_TestCase;
use Mockery;

class PresentationTest extends PHPUnit_Framework_TestCase
{
    protected static $fileClass = 'Derby\Media\File\Presentation';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Presentation($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Presentation($key, $filesystem, $metaData);

        $this->assertEquals(Presentation::TYPE_MEDIA_FILE_PRESENTATION, $sut->getMediaType());
    }
}
