<?php

namespace Derby\Tests\Integration\Media\Embed\YouTube;

use Derby\Media\Embed\YouTube\YouTubeVideo;
use Derby\Adapter\Embed\YouTubeVideoAdapter;

class YouTubeVideoTest extends \PHPUnit_Framework_TestCase
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
     * @var YouTubeVideo
     */
    protected $validVideo;

    /**
     * @var YouTubeVideo
     */
    protected $invalidVideo;

    /**
     * Fixture Setup
     */
    public function setup()
    {
        $this->client = new \Google_Client();
        $credentials = json_decode(file_get_contents(__DIR__.'/../../../Temp/credentials.json'), true);
        $this->client->setDeveloperKey($credentials['youtube_api_key']);
        $this->adapter = new YouTubeVideoAdapter($this->client);
        $this->validVideo = $this->adapter->getMedia('fHVga3_Z8Xg');
        $this->invalidVideo = $this->adapter->getMedia('I-DO-NOT-EXIST');
    }

    public function testInvalidVideo()
    {
        $this->assertFalse($this->invalidVideo->exists());
    }

    public function testValidVideo()
    {
        $this->assertTrue($this->validVideo->exists());
    }

    public function testGetThumbnail()
    {
        $this->assertEquals(
            array(
                'height' => 90,
                'width'  => 120,
                'url'    => 'https://i.ytimg.com/vi/fHVga3_Z8Xg/default.jpg'
            ),
            $this->validVideo->getThumbnail()
        );
        $this->assertEquals(
            array(
                'height' => 480,
                'width'  => 640,
                'url'    => 'https://i.ytimg.com/vi/fHVga3_Z8Xg/sddefault.jpg'
            ),
            $this->validVideo->getThumbnail('standard')
        );
        $this->assertEquals(
            array(
                'height' => 360,
                'width'  => 480,
                'url'    => 'https://i.ytimg.com/vi/fHVga3_Z8Xg/hqdefault.jpg'
            ),
            $this->validVideo->getThumbnail('high')
        );
        $this->assertEquals(
            array(
                'height' => 90,
                'width'  => 120,
                'url'    => 'https://i.ytimg.com/vi/fHVga3_Z8Xg/default.jpg'
            ),
            $this->validVideo->getThumbnail('maxres')
        );
        $this->assertEquals(
            array(
                'height' => 180,
                'width'  => 320,
                'url'    => 'https://i.ytimg.com/vi/fHVga3_Z8Xg/mqdefault.jpg'
            ),
            $this->validVideo->getThumbnail('medium')
        );
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetThumbnailFail()
    {
        $this->invalidVideo->getThumbnail();
    }

    public function testGetCategoryId()
    {
        $this->assertEquals('24', $this->validVideo->getCategoryId());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetCategoryIdFail()
    {
        $this->invalidVideo->getCategoryId();
    }

    public function testGetPublishedAt()
    {
        $this->assertEquals(new \DateTime('2015-05-26 18:08:19'), $this->validVideo->getPublishedAt());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetPublishedAtFail()
    {
        $this->invalidVideo->getPublishedAt();
    }

    public function testGetChannelId()
    {
        $this->assertEquals('UCIdBVOBKSpZqkvSxijfqBqw', $this->validVideo->getChannelId());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetChannelIdFail()
    {
        $this->invalidVideo->getChannelId();
    }

    public function testGetTitle()
    {
        $this->assertEquals('Mindgruve Agency Sizzle Reel - HD', $this->validVideo->getTitle());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetTitleFail()
    {
        $this->invalidVideo->getTitle();
    }

    public function testGetChannelTitle()
    {
        $this->assertEquals('Mindgruve', $this->validVideo->getChannelTitle());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetChannelTitleFail()
    {
        $this->invalidVideo->getChannelTitle();
    }

    public function testGetTags()
    {
        $this->assertEquals(array('Digital Marketing (Industry)'), $this->validVideo->getTags());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetTagsFail()
    {
        $this->invalidVideo->getTags();
    }

    public function testDuration()
    {
        $this->assertEquals('PT1M4S', $this->validVideo->getDuration());

    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testDurationException()
    {
        $this->invalidVideo->getDuration();
    }

    public function testFormattedDuration()
    {
        $this->assertEquals('00:01:04', $this->validVideo->getFormattedDuration());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testDurationExceptionFail()
    {
        $this->invalidVideo->getFormattedDuration();
    }

    public function testDefinition()
    {
        $this->assertEquals('hd', $this->validVideo->getDefinition());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testDefinitionExceptionFail()
    {
        $this->invalidVideo->getDefinition();
    }

    public function testHasCaption()
    {
        $this->assertFalse($this->validVideo->hasCaption());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testHasCaptionFail()
    {
        $this->invalidVideo->hasCaption();
    }

    public function testIsLicensedContent()
    {
        $this->assertFalse($this->validVideo->isLicensedContent());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testIsLicensedFail()
    {
        $this->invalidVideo->isLicensedContent();
    }

    public function testIsEmbeddable()
    {
        $this->assertFalse($this->validVideo->isEmbeddable());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testIsEmbeddableFail()
    {
        $this->invalidVideo->isEmbeddable();
    }

    public function testGetLicense()
    {
        $this->assertEquals('youtube', $this->validVideo->getLicense());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetLicenseFail()
    {
        $this->invalidVideo->getLicense();
    }

    public function getPrivacyStatus()
    {
        $this->assertEquals('public', $this->validVideo->getPrivacyStatus());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function getPrivacyStatusFail()
    {
        $this->invalidVideo->getPrivacyStatus();
    }

    public function isPublicStatsViewable()
    {
        $this->assertTrue($this->validVideo->isPublicStatusViewable());
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function isPublicStatsViewableFail()
    {
        $this->invalidVideo->isPublicStatusViewable();
    }

    public function testGetViewCount()
    {
        $this->assertTrue(is_numeric($this->validVideo->getViewCount()));
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetViewCountFail()
    {
        $this->invalidVideo->getViewCount();
    }

    public function testGetLikeCount()
    {
        $this->assertTrue(is_numeric($this->validVideo->getLikeCount()));
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetLikeCountFail()
    {
        $this->invalidVideo->getLikeCount();
    }

    public function testGetDislikeCount()
    {
        $this->assertTrue(is_numeric($this->validVideo->getDislikeCount()));
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetDislikeCountFail()
    {
        $this->invalidVideo->getDislikeCount();
    }

    public function testGetFavoriteCount()
    {
        $this->assertTrue(is_numeric($this->validVideo->getFavoriteCount()));
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetFavoriteCountFail()
    {
        $this->invalidVideo->getFavoriteCount();
    }

    public function testGetCommentCount()
    {
        $this->assertTrue(is_numeric($this->validVideo->getCommentCount()));
    }

    /**
     * @expectedException     \Derby\Exception\MediaNotFoundException
     */
    public function testGetCommentCountFail()
    {
        $this->invalidVideo->getCommentCount();
    }
}