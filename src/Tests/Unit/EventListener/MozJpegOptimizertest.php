<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\MozJpegOptimize;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Derby\Events;

class MozJpegOptimizerTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $sut = new MozJpegOptimize();

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new MozJpegOptimize();

        $this->assertEquals(array(
            Events::IMAGE_PRE_SAVE => array('onImagePreSave', 0),
        ), $sut->getSubscribedEvents());
    }
}