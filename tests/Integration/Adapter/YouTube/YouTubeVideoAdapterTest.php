<?php

namespace Derby\Tests\Integration\Adapter\YouTube;

use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Doctrine\Common\Cache\ArrayCache;
use Derby\Cache\DerbyCache;

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
        if (!file_exists(__DIR__.'/../../../credentials.json')) {
            echo 'YouTube Credentials Do Not Exist'.PHP_EOL;
            return;
        }
        $this->client = new \Google_Client();
        $credentials = json_decode(file_get_contents(__DIR__.'/../../../credentials.json'), true);
        $this->client->setDeveloperKey($credentials['youtube_api_key']);
        $cache = new DerbyCache(new ArrayCache(), 3600);
        $this->adapter = new YouTubeVideoAdapter('youtube.video',$this->client, $cache);
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

    public function testParseYouTubeURLNotExist()
    {
        $youTubeVideo = $this->adapter->parseYouTubeURL('https://www.youtube.com/watch?v=I-DO-NOT-EXIST');
        $this->assertFalse($youTubeVideo->exists());
    }

    public function testRefresh()
    {
        $video = $this->adapter->refresh('fHVga3_Z8Xg');
        $this->assertTrue($video->exists());
    }
}