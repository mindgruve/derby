<?php

namespace Derby\Tests\Unit\Media\Factory;

use Derby\Media\Factory\FileFactory;
use Derby\Media\Factory\SpreadsheetFactory;
use Derby\Media\File\Spreadsheet;
Use Mockery;

class SpreadsheetFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\FactoryInterface';
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