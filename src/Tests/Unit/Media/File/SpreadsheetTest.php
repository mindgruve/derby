<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\File\Spreadsheet;

class SpreadsheetTest extends PHPUnit_Framework_TestCase
{

    protected static $fileClass = 'Derby\Media\File\Spreadsheet';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Spreadsheet($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new Spreadsheet($key, $filesystem, $metaData);

        $this->assertEquals(File\Spreadsheet::TYPE_MEDIA_FILE_SPREADSHEET, $sut->getMediaType());
    }

}
