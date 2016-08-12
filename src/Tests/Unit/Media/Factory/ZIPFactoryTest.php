<?php

namespace Derby\Tests\Unit\Media\Factory;

use Derby\Media\Factory\FileFactory;
use Derby\Media\Factory\ZipFactory;
use Derby\Media\File\Zip;
Use Mockery;

class ZipFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new ZipFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new ZipFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Zip);
    }

}