<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Image;
use PHPUnit_Framework_TestCase;
use Mockery;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';
    protected static $abstractImagine = 'Imagine\Image\AbstractImagine';

    public function testInterface()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertTrue($sut instanceof File);
    }

    public function testDefaultQuality()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertEquals(100, $sut->getQuality());

    }

    public function testSetQuality()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);
        $sut->setQuality(85);

        $this->assertEquals(85, $sut->getQuality());
    }

    public function testDefaultFocusPoint()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertEquals(0, $sut->getFocusPointX());
        $this->assertEquals(0, $sut->getFocusPointY());
    }

    public function testSetFocusPoint()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new Image($key, $adapter, $imagine);

        $this->assertEquals(0, $sut->getFocusPointX());
        $this->assertEquals(0, $sut->getFocusPointY());

        $sut->setFocusPointX(-.5);
        $sut->setFocusPointY(-.5);

        $this->assertEquals(-.5, $sut->getFocusPointX());
        $this->assertEquals(-.5, $sut->getFocusPointY());
    }
}