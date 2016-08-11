<?php

namespace Derby\Tests\Unit\Media\Embed\YouTube;

use Derby\Media\Embed\YouTube\YouTubeVideo;

class YouTubeVideoTest extends \PHPUnit_Framework_TestCase
{

    protected $mockAdapter;

    protected $mockClient;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        $this->mockAdapter = \Mockery::mock('Derby\Adapter\Embed\YouTubeVideoAdapter');
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
}