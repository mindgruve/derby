<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Factory\FactoryInterface;
use Derby\Media\File\Factory\FileFactory;
Use Mockery;

class FileFactoryTest extends \PHPUnit_Framework_TestCase
{

    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';
    protected static $fileInterface = 'Derby\Media\FileInterface';


    public function testInterface()
    {
        $sut = new FileFactory(array());

        $this->assertTrue($sut instanceof FactoryInterface);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new FileFactory(array());
        $file = $sut->build('foo', $adapter);

        $this->assertTrue($file instanceof File);
    }

    public function testExtensions()
    {
        $file = Mockery::mock(self::$fileInterface);
        $file->shouldReceive('getFileExtension')->andReturn('mp3');

        $sut = new FileFactory(array('mp3', 'wav', 'wma'));

        $this->assertTrue($sut->supports($file));
    }

    public function testExtensionFail()
    {
        $file = Mockery::mock(self::$fileInterface);
        $file->shouldReceive('getFileExtension')->andReturn('docx');

        $sut = new FileFactory(array('mp3', 'wav', 'wma'));

        $this->assertFalse($sut->supports($file));
    }

}