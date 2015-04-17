<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Document;
use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;

class DocumentTest extends PHPUnit_Framework_TestCase
{
    protected static $fileClass = 'Derby\Media\File\Document';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Document($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Document($key, $filesystem, $metaData);

        $this->assertEquals(Document::TYPE_MEDIA_FILE_DOCUMENT, $sut->getMediaType());
    }
}
