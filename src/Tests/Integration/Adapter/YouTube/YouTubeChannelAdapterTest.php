<?php

namespace Derby\Tests\Integration\Adapter\YouTube;

use Derby\Adapter\YouTube\YouTubeChannelAdapter;
use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\Media\YouTube\YouTubeVideo;
use Doctrine\Common\Cache\ArrayCache;
use Derby\Cache\DerbyCache;

class YouTubeChannelAdapterTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var YouTubeChannelAdapter
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
        $cache = new DerbyCache(new ArrayCache(), 3600);
        $videoAdapter = new YouTubeVideoAdapter($this->client, $cache);
        $this->adapter = new YouTubeChannelAdapter($this->client, $videoAdapter, $cache);
    }

    /**
     * Test that exists() returns false if channel doesn't exist
     */
    public function testInvalidChannel()
    {
        $this->assertFalse($this->adapter->exists('I-DO-NOT-EXIST'));

    }

    /**
     * Test that channel is valid
     */
    public function testValidChannel()
    {
        /**
         * Test Mindgruve Channel
         * https://www.youtube.com/channel/UCIdBVOBKSpZqkvSxijfqBqw
         */
        $this->assertTrue($this->adapter->exists('UCIdBVOBKSpZqkvSxijfqBqw'));
    }

    /**
     * Test that sizzle reel is a video in the Mindgruve channel
     */
    public function testContains()
    {
        $cache = new DerbyCache(new ArrayCache(), 3600);
        $youtubeVideoAdapter = new YouTubeVideoAdapter($this->client, $cache);
        $video = $youtubeVideoAdapter->getMedia('fHVga3_Z8Xg');

        $this->assertTrue($this->adapter->contains('UCIdBVOBKSpZqkvSxijfqBqw', $video));
    }

    /**
     * Test that fake video is not in the Mindgruve channel
     */
    public function testNotContains()
    {
        $cache = new DerbyCache(new ArrayCache(), 3600);
        $youtubeVideoAdapter = new YouTubeVideoAdapter($this->client, $cache);
        $video = $youtubeVideoAdapter->getMedia('I-DO-NOT-EXIST');

        $this->assertFalse($this->adapter->contains('UCIdBVOBKSpZqkvSxijfqBqw', $video));
    }

    /**
     * Confirm the number of videos in the mindgruve channel
     * This might change as mindgruve uploads more videos
     */
    public function testCount()
    {
        $this->assertEquals(25, $this->adapter->count('UCIdBVOBKSpZqkvSxijfqBqw'));
    }

    public function testGetItems()
    {
        $items = $this->adapter->getItems('UCIdBVOBKSpZqkvSxijfqBqw', 1, 5);
        $this->assertTrue(is_array($items));
        $this->assertEquals(5, count($items));

        foreach ($items as $item) {
            $this->assertTrue($item instanceof YouTubeVideo);
        }
    }

    public function testGetItemsNextPage(){
        $items = $this->adapter->getItems('UCIdBVOBKSpZqkvSxijfqBqw', 2, 5);
        $this->assertTrue(is_array($items));
        $this->assertEquals(5, count($items));

        foreach ($items as $item) {
            $this->assertTrue($item instanceof YouTubeVideo);
        }
    }

    /**
     * @expectedException     \Exception
     */
    public function testGetItemsException()
    {
        $this->adapter->getItems('UCIdBVOBKSpZqkvSxijfqBqw', 1, 51);
    }
}