<?php

namespace Derby\Tests\Integration\Adapter\Embed;

use Derby\Adapter\Embed\YouTubeVideoAdapter;
use Derby\Media\Embed\YouTube\YouTubeVideo;

class YouTubeVideoAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var YouTubeVideoAdapter
     */
    protected $adapter;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        $this->client = new \Google_Client();
        $credentials = json_decode(file_get_contents(__DIR__.'/../../../credentials.json'), true);
        $this->client->setDeveloperKey($credentials['youtube_api_key']);
        $this->adapter = new YouTubeVideoAdapter($this->client);
    }

    /**
     * Test the constructor
     */
    public function testConstructor()
    {
        $this->assertEquals(YouTubeVideoAdapter::ADAPTER_YOU_TUBE_VIDEO, $this->adapter->getAdapterType());
    }

    /**
     * Test that exists() returns false if video doesn't exist
     */
    public function testInvalidVideo()
    {
        $this->assertFalse($this->adapter->exists('I-DO-NOT-EXIST'));
    }

    /**
     * Test that exists() returns true if video does exist
     */
    public function testValidVideo()
    {

        /**
         * Test Mindgruve Sizzle Reel
         * https://www.youtube.com/watch?v=fHVga3_Z8Xg
         */
        $this->assertTrue($this->adapter->exists('fHVga3_Z8Xg'));
    }
}