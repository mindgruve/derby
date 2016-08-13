<?php

namespace Derby\Tests\Unit\Media\YouTube;

use Derby\Media\CollectionInterface;
use Derby\Media\YouTube\YouTubeChannel;

class YouTubeChannelTest extends \PHPUnit_Framework_TestCase
{


    protected $mockAdapter;

    protected $mockClient;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        $this->mockAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeChannelAdapter');
        $this->mockClient = \Mockery::mock('\Google_Client');
    }

    public function testConstructor()
    {
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);

        $this->assertTrue($sut instanceof CollectionInterface);
    }

    /**
     * @expectedException     \Derby\Exception\DerbyException
     */
    public function testAdd()
    {
        $mockVideo = \Mockery::mock('Derby\Media\YouTube\YouTubeVideo');
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $sut->add($mockVideo);
    }

    public function testGetKey()
    {
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $this->assertEquals('TEST-CHANNEL', $sut->getKey());
    }

    /**
     * @expectedException     \Derby\Exception\DerbyException
     */
    public function testRemove()
    {
        $mockVideo = \Mockery::mock('Derby\Media\YouTube\YouTubeVideo');
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $sut->remove($mockVideo);
    }

    public function testSetAdapter()
    {
        $newMockAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeChannelAdapter');
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $sut->setAdapter($newMockAdapter);
        $this->assertEquals($newMockAdapter, $sut->getAdapter());
    }

    public function testSetKey()
    {
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $this->assertEquals('TEST-CHANNEL', $sut->getKey());
        $sut->setKey('NEW-CHANNEL');
        $this->assertEquals('NEW-CHANNEL', $sut->getKey());
    }

    public function testRefresh()
    {
        $sut = new YouTubeChannel('TEST-CHANNEL', $this->mockAdapter);
        $this->mockAdapter->shouldReceive('refresh')->with('TEST-CHANNEL');
        $sut->refresh();
    }
}