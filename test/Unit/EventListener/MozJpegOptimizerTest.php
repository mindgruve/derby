<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\MozJpegOptimize;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Derby\Events;

class MozJpegOptimizerTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $sut = new MozJpegOptimize('/tmp', '/opt/mozjpeg/bin/cjpeg');

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new MozJpegOptimize('/tmp', '/opt/mozjpeg/bin/cjpeg');

        $this->assertEquals(array(
            Events::IMAGE_PRE_SAVE => array('onMediaImagePreSave', 0),
        ), $sut->getSubscribedEvents());
    }
}