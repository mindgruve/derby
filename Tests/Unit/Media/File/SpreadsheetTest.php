<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\File\Spreadsheet;

class SpreadsheetTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Spreadsheet($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Spreadsheet($key, $adapter);

        $this->assertEquals(Spreadsheet::TYPE_MEDIA_FILE_SPREADSHEET, $sut->getMediaType());
    }

}
