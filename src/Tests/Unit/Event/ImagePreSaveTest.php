<?php

namespace Derby\Tests\Unit\Event;

use Derby\Event\ImagePreSave;
use PHPUnit_Framework_TestCase;
use Mockery;
use Symfony\Component\EventDispatcher\Event;

class ImagePreSaveTest extends PHPUnit_Framework_TestCase
{

    protected static $imageInterface = 'Derby\Media\File\Image';

    public function testInterface()
    {
        $image = Mockery::mock(self::$imageInterface);

        $sut = new ImagePreSave($image);

        $this->assertTrue($sut instanceof Event);
    }

    public function testGetImage()
    {
        $image = Mockery::mock(self::$imageInterface);

        $sut = new ImagePreSave($image);

        $this->assertEquals($image, $sut->getImage());
    }

    public function testSetImage()
    {
        $image = Mockery::mock(self::$imageInterface);
        $image2 = Mockery::mock(self::$imageInterface);

        $sut = new ImagePreSave($image);
        $sut->setImage($image2);

        $this->assertEquals($image2, $sut->getImage());
    }
}