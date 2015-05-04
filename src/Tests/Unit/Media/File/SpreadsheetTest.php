<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\LocalFile\Spreadsheet;

class SpreadsheetTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Spreadsheet($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Spreadsheet($key, $adapter);

        $this->assertEquals(Spreadsheet::TYPE_MEDIA_FILE_SPREADSHEET, $sut->getMediaType());
    }

}
