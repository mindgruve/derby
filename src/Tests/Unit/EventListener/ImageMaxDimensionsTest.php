<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\ImageMaxDimensions;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ImageMaxDimensionsTest extends \PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $sut = new ImageMaxDimensions('/tmp', 'convert', 100, 100);

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new ImageMaxDimensions('/tmp', 'convert', 100, 100);

        $this->assertEquals(array(
            Events::IMAGE_PRE_LOAD => array('onMediaImagePreLoad', 0),
        ), $sut->getSubscribedEvents());
    }

}