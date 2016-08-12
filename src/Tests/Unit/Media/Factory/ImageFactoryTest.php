<?php

namespace Derby\Tests\Unit\Media\Factory;

use Derby\Media\Factory\FileFactory;
use Derby\Media\Factory\ImageFactory;
use Derby\Media\File\Image;
Use Mockery;

class ImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';
    protected static $abstractImagine = 'Imagine\Image\AbstractImagine';

    public function testInterface()
    {
        $imagine = Mockery::mock(self::$abstractImagine);
        $sut = new ImageFactory(array(),$imagine);
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $imagine = Mockery::mock(self::$abstractImagine);

        $sut = new ImageFactory(array(),$imagine);
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Image);
    }

}