<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Factory\FileFactory;
use Derby\Media\File\Factory\SpreadsheetFactory;
use Derby\Media\File\Spreadsheet;
Use Mockery;

class SpreadsheetFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new SpreadsheetFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new SpreadsheetFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Spreadsheet);
    }

}