<?php

namespace Derby\Media\Embed\YouTube;

use Derby\Exception\MediaNotFoundException;
use Derby\Media\Embed;

class YouTubeVideo extends Embed
{

    const TYPE_MEDIA_EMBED_YOUTUBE_VIDEO = 'MEDIA/EMBED/YOUTUBE/VIDEO';

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var \Google_Service_YouTube
     */
    protected $youTubeService;

    /**
     * @var \Google_Service_YouTube_Video
     */
    protected $video;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @param $key
     * @param \Derby\Adapter\EmbedAdapterInterface $adapter
     * @param \Google_Client $client
     */
    public function __construct($key, $adapter, \Google_Client $client)
    {
        $this->key = $key;
        $this->adapter = $adapter;
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_EMBED_YOUTUBE_VIDEO;
    }

    /**
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    protected function init()
    {
        if ($this->initialized) {
            return;
        }

        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->youTubeService->videos->listVideos(
            'snippet,statistics,status,contentDetails',
            array('id' => $this->key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Video) {
            $this->video = $items[0];
        } else {
            throw new MediaNotFoundException('YouTube Video Not Found- '.$this->key);
        }

        $this->initialized = true;
    }

    /**
     * Get Snippet object of a video
     * https://developers.google.com/youtube/v3/docs/videos#snippet
     * @param $key
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    protected function getSnippetField($key)
    {
        $this->init();
        $snippet = $this->video->getSnippet();

        if (isset($snippet[$key])) {
            return $snippet[$key];
        }

        throw new \Exception('Invalid key for Snippet Object');
    }

    /**
     * Get Statistic object of a video
     * https://developers.google.com/youtube/v3/docs/videos#statistics
     * @param $key
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    protected function getStatisticsField($key)
    {
        $this->init();
        $statistics = $this->video->getStatistics();

        if (isset($statistics[$key])) {
            return $statistics[$key];
        }

        throw new \Exception('Invalid key for Statistics Object');
    }

    /**
     * Get ContentDetails object of a video
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails
     * @param $key
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    protected function getContentDetailsField($key)
    {
        $this->init();

        $contentDetails = $this->video->getContentDetails();

        if (isset($contentDetails[$key])) {
            return $contentDetails[$key];
        }

        throw new \Exception('Invalid key for ContentDetails Object');
    }

    /**
     * Get Status object of a video
     * https://developers.google.com/youtube/v3/docs/videos#status
     * @param $key
     * @return mixed
     * @throws MediaNotFoundException
     * @throws \Exception
     */
    protected function getStatusField($key)
    {
        $this->init();

        $status = $this->video->getStatus();

        if (isset($status[$key])) {
            return $status[$key];
        }

        throw new \Exception('Invalid key for Status Object');
    }

    /**
     * Get video thumbnail
     * https://developers.google.com/youtube/v3/docs/videos#snippet.thumbnails
     * @param string $size
     * @return array|null
     * @throws \Exception
     */
    public function getThumbnail($size = 'default')
    {
        $thumbnails = $this->getSnippetField('thumbnails');
        $default = $thumbnails->getDefault();
        $high = $thumbnails->getHigh();
        $maxres = $thumbnails->getMaxres();
        $medium = $thumbnails->getMedium();
        $standard = $thumbnails->getStandard();

        $default = $default ? array(
            'height' => $default->getHeight(),
            'width'  => $default->getWidth(),
            'url'    => $default->getUrl()
        ) : null;

        switch ($size) {
            case 'default':
                return $default;
            case 'high':
                return $high ? array(
                    'height' => $high->getHeight(),
                    'width'  => $high->getWidth(),
                    'url'    => $high->geturl()
                ) : $default;
            case 'maxres':
                return $maxres ? array(
                    'height' => $maxres->getHeight(),
                    'width'  => $maxres->getWidth(),
                    'url'    => $maxres->geturl()
                ) : $default;
            case 'medium':
                return $high ? array(
                    'height' => $medium->getHeight(),
                    'width'  => $medium->getWidth(),
                    'url'    => $medium->geturl()
                ) : $default;
            case 'standard':
                return $standard ? array(
                    'height' => $standard->getHeight(),
                    'width'  => $standard->getWidth(),
                    'url'    => $standard->geturl()
                ) : $default;
        }
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.categoryId
     * @return mixed
     * @throws \Exception
     */
    public function getCategoryId()
    {
        return $this->getSnippetField('categoryId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.publishedAt
     * @return mixed
     * @throws \Exception
     */
    public function getPublishedAt()
    {
        return new \DateTime($this->getSnippetField('publishedAt'));
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelId
     * @return mixed
     * @throws \Exception
     */
    public function getChannelId()
    {
        return $this->getSnippetField('channelId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelTitle
     * @return mixed
     * @throws \Exception
     */
    public function getChannelTitle()
    {
        return $this->getSnippetField('channelTitle');
    }


    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.title
     * @return mixed
     * @throws \Exception
     */
    public function getTitle(){
        return $this->getSnippetField('title');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.description
     * @return mixed
     * @throws \Exception
     */
    public function getDescription(){
        return $this->getSnippetField('description');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.tags
     * @return mixed
     * @throws \Exception
     */
    public function getTags(){
        return $this->getSnippetField('tags');
    }

    /**
     * Get Duration
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.duration
     * @return string
     * @throws \Exception
     */
    public function getDuration()
    {
        return $this->getContentDetailsField('duration');
    }

    /**
     * Get Duration formatted as a string.
     * @param string $format
     * @return string
     */
    public function getFormattedDuration($format = 'H:i:s')
    {
        $start = new \DateTime('@0'); // Unix epoch
        $start->add(new \DateInterval($this->getDuration()));

        return $start->format($format);

    }

    /**
     * Returns whether video is available in SD or HD
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.definition
     * @return string
     * @throws \Exception
     */
    public function getDefinition()
    {
        return $this->getContentDetailsField('definition');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.caption
     * True if video has captions
     * @return bool
     * @throws \Exception
     */
    public function hasCaption()
    {
        if ($this->getContentDetailsField('caption') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.licensedContent
     * True if video is licensed
     * @return bool
     * @throws \Exception
     */
    public function isLicensedContent()
    {
        if ($this->getContentDetailsField('licensedContent') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.embeddable
     * True if video is embeddable
     * @return bool
     * @throws \Exception
     */
    public function isEmbeddable()
    {
        if ($this->getStatusField('embeddable') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.license
     * Returns the license of the video
     * @return mixed
     * @throws \Exception
     */
    public function getLicense()
    {
        return $this->getStatusField('license');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.privacyStatus
     * Returns the privacy status of the video
     * @return mixed
     * @throws \Exception
     */
    public function getPrivacyStatus()
    {
        return $this->getStatusField('privacyStatus');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.publicStatsViewable
     * Returns true if the stats are publicly visible
     * @return mixed
     * @throws \Exception
     */
    public function isPublicStatusViewable()
    {
        if ($this->getStatusField('publicStatsViewable') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.viewCount
     * @return int
     * @throws \Exception
     */
    public function getViewCount(){
        return $this->getStatisticsField('viewCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.likeCount
     * @return int
     * @throws \Exception
     */
    public function getLikeCount(){
        return $this->getStatisticsField('likeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.dislikeCount
     * @return int
     * @throws \Exception
     */
    public function getDislikeCount(){
        return $this->getStatisticsField('dislikeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.favoriteCount
     * @return int
     * @throws \Exception
     */
    public function getFavoriteCount(){
        return $this->getStatisticsField('favoriteCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.commentCount
     * @return int
     * @throws \Exception
     */
    public function getCommentCount(){
        return $this->getStatisticsField('commentCount');
    }
}

