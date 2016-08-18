<?php

namespace Derby\Tests\Unit\Adapter\YouTube;

use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\Adapter\AdapterInterface;
use Derby\Exception\DerbyException;
use Derby\Media\YouTube\YouTubeVideo;
use Derby\Media\MediaInterface;

class YouTubeVideoAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);

        /**
         * Test Interfaces
         */

        $this->assertTrue($sut instanceof AdapterInterface);
        $this->assertEquals('youtube.video',$sut->getAdapterKey());
    }

    public function testAdapterType()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);

        $this->assertEquals(YouTubeVideoAdapter::ADAPTER_YOU_TUBE_VIDEO, $sut->getAdapterType());
    }

    public function testGetMedia()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);
        $video = $sut->getMedia('SAMPLE-VIDEO');

        $this->assertTrue($video instanceof MediaInterface);
        $this->assertTrue($video instanceof YouTubeVideo);
    }


    public function testParseYouTubeURL()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);

        $youTubeVideo = $sut->parseYouTubeURL('https://www.youtube.com/watch?v=fHVga3_Z8Xg');
        $this->assertTrue($youTubeVideo instanceof YouTubeVideo);
        $this->assertEquals('fHVga3_Z8Xg', $youTubeVideo->getKey());

        $youTubeVideo = $sut->parseYouTubeURL('https://youtube.com/embed/fHVga3_Z8Xg');
        $this->assertTrue($youTubeVideo instanceof YouTubeVideo);
        $this->assertEquals('fHVga3_Z8Xg', $youTubeVideo->getKey());

        $youTubeVideo = $sut->parseYouTubeURL('https://youtu.be/fHVga3_Z8Xg');
        $this->assertTrue($youTubeVideo instanceof YouTubeVideo);
        $this->assertEquals('fHVga3_Z8Xg', $youTubeVideo->getKey());
    }

    public function testParseYouTubeURLFail()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);

        try {
            $sut->parseYouTubeURL('https://www.youtube.com/watch');
            $this->fail('Exception not thrown when parsing invalid youtube url');
        } catch (DerbyException $e) {
            $this->assertEquals('Unable to parse YouTube URL', $e->getMessage());
        }

        try {
            $sut->parseYouTubeURL('http://www.mindgruve.com');
            $this->fail('Exception not thrown when parsing invalid youtube url');
        } catch (DerbyException $e) {
            $this->assertEquals('Unable to parse YouTube URL', $e->getMessage());
        }
    }

    public function testSetAndGetAdapterKey()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $cache = \Mockery::mock('Derby\Cache\DerbyCache');
        $sut = new YouTubeVideoAdapter('youtube.video', $mockClient, $cache);

        $this->assertEquals('youtube.video', $sut->getAdapterKey());
        $sut->setAdapterKey('youtube.video2');
        $this->assertEquals('youtube.video2', $sut->getAdapterKey());
    }
}