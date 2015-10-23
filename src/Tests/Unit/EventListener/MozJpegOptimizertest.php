<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\MozJpegOptimizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Derby\Events;

class MozJpegOptimizerTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $sut = new MozJpegOptimizer();

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new MozJpegOptimizer();

        $this->assertEquals(array(
            Events::IMAGE_PRE_SAVE => array('onImagePreSave', 0),
        ), $sut->getSubscribedEvents());
    }
}