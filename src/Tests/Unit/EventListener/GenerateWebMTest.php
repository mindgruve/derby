<?php

namespace Derby\Tests\Unit\EventListener;

use Derby\EventListener\GenerateWebM;
use Derby\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GenerateWebMTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $sut = new GenerateWebM('cwebp', '/tmp');

        $this->assertTrue($sut instanceof EventSubscriberInterface);
    }

    public function testGetSubscribedEvents()
    {
        $sut = new GenerateWebM('cwebp', '/tmp');

        $this->assertEquals(array(
            Events::IMAGE_POST_SAVE => array('onMediaImagePostSave', 0),
        ), $sut->getSubscribedEvents());
    }
}