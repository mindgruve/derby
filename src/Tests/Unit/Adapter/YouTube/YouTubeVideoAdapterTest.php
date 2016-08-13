<?php

namespace Derby\Tests\Unit\Adapter\YouTube;

use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\AdapterInterface;
use Derby\Exception\DerbyException;
use Derby\Media\YouTube\YouTubeVideo;
use Derby\MediaInterface;

class YouTubeVideoAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $sut = new YouTubeVideoAdapter($mockClient);

        /**
         * Test Interfaces
         */

        $this->assertTrue($sut instanceof AdapterInterface);
    }

    public function testAdapterType()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $sut = new YouTubeVideoAdapter($mockClient);

        $this->assertEquals(YouTubeVideoAdapter::ADAPTER_YOU_TUBE_VIDEO, $sut->getAdapterType());
    }

    public function testGetMedia()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $sut = new YouTubeVideoAdapter($mockClient);
        $video = $sut->getMedia('SAMPLE-VIDEO');

        $this->assertTrue($video instanceof MediaInterface);
        $this->assertTrue($video instanceof YouTubeVideo);
    }


    public function testParseYouTubeURL()
    {
        $mockClient = \Mockery::mock('\Google_Client');
        $sut = new YouTubeVideoAdapter($mockClient);

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
        $sut = new YouTubeVideoAdapter($mockClient);

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
}