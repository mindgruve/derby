<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\ImageFormatNormalize;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageFormatNormalizeTest extends \PHPUnit_Framework_TestCase
{

    protected $formats = array(
        'bmp' => 'jpg',
        'ico' => 'png',
        'tiff' => 'jpg',
        'svg' => 'png',
        'psd' => 'png'
    );

    public function testInterface()
    {
        $sut = new ImageFormatNormalize('/tmp', 'convert', $this->formats);

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new ImageFormatNormalize('/tmp', 'convert', $this->formats);

        $this->assertEquals(array(
            Events::IMAGE_PRE_LOAD => array('onMediaImagePreLoad', 0),
        ), $sut->getSubscribedEvents());
    }

}