<?php

namespace Derby\Tests\Unit\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Adapter\YouTube\YouTubeChannelAdapter;
use Derby\Media\CollectionInterface;
use Derby\Media\YouTube\YouTubeChannel;

class YouTubeChannelAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $mockVideoAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeVideoAdapter');
        $sut = new YouTubeChannelAdapter($mockClient, $mockVideoAdapter);

        /**
         * Test Interfaces
         */

        $this->assertTrue($sut instanceof CollectionAdapterInterface);
    }

    public function testAdapterType()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $mockVideoAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeVideoAdapter');
        $sut = new YouTubeChannelAdapter($mockClient, $mockVideoAdapter);

        $this->assertEquals(YouTubeChannelAdapter::ADAPTER_YOU_TUBE_CHANNEL, $sut->getAdapterType());
    }

    public function testGetMedia()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $mockVideoAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeVideoAdapter');
        $sut = new YouTubeChannelAdapter($mockClient, $mockVideoAdapter);
        $channel = $sut->getMedia('SAMPLE-CHANNEL');

        $this->assertTrue($channel instanceof CollectionInterface);
        $this->assertTrue($channel instanceof YouTubeChannel);
    }
}