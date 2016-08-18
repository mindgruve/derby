<?php

namespace Derby\Tests\Integration\Media\YouTube\YouTube;

use Derby\Adapter\YouTube\YouTubeChannelAdapter;
use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\Cache\ResultPage;
use Derby\Media\YouTube\YouTubeVideo;
use Derby\Media\YouTube\YouTubeChannel;
use Doctrine\Common\Cache\ArrayCache;
use Derby\Cache\DerbyCache;

class YouTubeChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var YouTubeVideoAdapter
     */
    protected $videoAdapter;

    /**
     * @var YouTubeChannelAdapter
     */
    protected $channelAdapter;

    /**
     * @var YouTubeVideo
     */
    protected $validVideo;

    /**
     * @var YouTubeVideo
     */
    protected $invalidVideo;

    /**
     * @var YouTubeChannel
     */
    protected $validChannel;

    /**
     * @var YouTubeChannel
     */
    protected $invalidChannel;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        if (!file_exists(__DIR__.'/../../../credentials.json')) {
            $this->markTestSkipped('YouTube Credentials Do Not Exist');
        }
        $this->client = new \Google_Client();
        $credentials = json_decode(file_get_contents(__DIR__.'/../../../credentials.json'), true);
        $this->client->setDeveloperKey($credentials['youtube_api_key']);
        $cache = new DerbyCache(new ArrayCache(), 3600);
        $this->videoAdapter = new YouTubeVideoAdapter('youtube.video',$this->client, $cache);
        $this->channelAdapter = new YouTubeChannelAdapter('youtube.channel',$this->client, $this->videoAdapter, $cache);
        $this->validVideo = $this->videoAdapter->getMedia('fHVga3_Z8Xg');
        $this->invalidVideo = $this->videoAdapter->getMedia('I-DO-NOT-EXIST');
        $this->validChannel = $this->channelAdapter->getMedia('UCIdBVOBKSpZqkvSxijfqBqw');
        $this->invalidChannel = $this->channelAdapter->getMedia('I-DO-NOT-EXIST');
    }


    public function testContains()
    {
        $this->assertTrue($this->validChannel->contains($this->validVideo));
    }

    public function testContainsFail()
    {
        $this->assertFalse($this->validChannel->contains($this->invalidVideo));

    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testContainsException()
    {
        $this->invalidChannel->contains($this->invalidVideo);
    }

    public function testCount()
    {
        $this->assertEquals(25, $this->validChannel->count());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testCountException()
    {
        $this->invalidChannel->count();
    }

    public function testExists()
    {
        $this->assertTrue($this->validChannel->exists());
    }

    public function testDoesNotExist()
    {
        $this->assertFalse($this->invalidChannel->exists());
    }

    public function testGetItems()
    {
        $resultPage = $this->validChannel->getItems(5);
        $this->assertTrue($resultPage instanceof ResultPage);
        $this->assertTrue($resultPage instanceof \Iterator);
        $this->assertTrue(is_array($resultPage->getItems()));
        $this->assertEquals(5, count($resultPage->getItems()));
        $this->assertEquals(5, $resultPage->getLimit());
        foreach ($resultPage->getItems() as $item) {
            $this->assertTrue($item instanceof YouTubeVideo);
        }
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetItemsException()
    {
        $this->invalidChannel->getItems(5);
    }

    /**
     * @expectedException     \Exception
     */
    public function testInvalidLImitException()
    {
        $this->validChannel->getItems(51);
    }

    public function testGetTitle()
    {
        $this->assertEquals('Mindgruve', $this->validChannel->getTitle());
    }

    /**
     * @expectedException     \Derby\Exception\DerbyException
     */
    public function testGetTitleFail()
    {
        $this->invalidChannel->getTitle();
    }
}