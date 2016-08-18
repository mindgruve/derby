<?php

namespace Derby\Tests\Unit\Media\YouTube;

use Derby\Media\YouTube\YouTubeVideo;

class YouTubeVideoTest extends \PHPUnit_Framework_TestCase
{

    protected $mockAdapter;

    protected $mockClient;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        $this->mockAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeVideoAdapter','Derby\Adapter\AdapterInterface');
        $this->mockClient = \Mockery::mock('\Google_Client');
    }

    public function testConstructor()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);
        $this->assertEquals(YouTubeVideo::TYPE_MEDIA_EMBED_YOUTUBE_VIDEO, $sut->getMediaType());
        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($this->mockAdapter, $sut->getAdapter());
    }

    public function testExists()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);
        $this->mockAdapter->shouldReceive('exists')->andReturn(true);
        $this->assertTrue($sut->exists());
    }

    public function testDoesNotExist()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);
        $this->mockAdapter->shouldReceive('exists')->andReturn(false);
        $this->assertFalse($sut->exists());
    }

    public function testSetKey()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);
        $this->assertEquals($key, $sut->getKey());
        $key2 = 'SAMPLE-VIDEO-2';
        $sut->setKey($key2);
        $this->assertEquals($key2, $sut->getKey());
    }

    public function testSetAdapter()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);
        $newAdapter = \Mockery::mock('Derby\Adapter\YouTube\YouTubeVideoAdapter','Derby\Adapter\AdapterInterface');
        $sut->setAdapter($newAdapter);
        $this->assertEquals($newAdapter, $sut->getAdapter());
    }

    public function testRefresh()
    {
        $key = 'SAMPLE-VIDEO';
        $sut = new YouTubeVideo($key, $this->mockAdapter, $this->mockClient);

        $this->mockAdapter->shouldReceive('refresh')->with($key);

        $sut->refresh();
    }
}