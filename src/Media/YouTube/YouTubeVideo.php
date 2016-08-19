<?php

namespace Derby\Media\YouTube;

use Derby\Adapter\AdapterInterface;
use Derby\Exception\DerbyException;
use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\Media\Media;

class YouTubeVideo extends Media
{

    /**
     * @param $mediaKey
     * @param YouTubeVideoAdapter $adapter
     */
    public function __construct($mediaKey, YouTubeVideoAdapter $adapter)
    {
        $this->mediaKey = $mediaKey;
        $this->adapter = $adapter;
    }

    /**
     * Get video thumbnail
     * https://developers.google.com/youtube/v3/docs/videos#snippet.thumbnails
     * @param string $size
     * @return array|null
     * @throws DerbyException
     */
    public function getThumbnail($size = 'default')
    {
        $thumbnails = $this->adapter->getSnippetField($this->getKey(), 'thumbnails');
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
     * @throws DerbyException
     */
    public function getCategoryId()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'categoryId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.publishedAt
     * @return mixed
     * @throws DerbyException
     */
    public function getPublishedAt()
    {
        return new \DateTime($this->adapter->getSnippetField($this->getKey(), 'publishedAt'));
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelId
     * @return mixed
     * @throws DerbyException
     */
    public function getChannelId()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'channelId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelTitle
     * @return mixed
     * @throws DerbyException
     */
    public function getChannelTitle()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'channelTitle');
    }


    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.title
     * @return mixed
     * @throws DerbyException
     */
    public function getTitle()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'title');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.description
     * @return mixed
     * @throws DerbyException
     */
    public function getDescription()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'description');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.tags
     * @return mixed
     * @throws DerbyException
     */
    public function getTags()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'tags');
    }

    /**
     * Get Duration
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.duration
     * @return string
     * @throws DerbyException
     */
    public function getDuration()
    {
        return $this->adapter->getContentDetailsField($this->getKey(), 'duration');
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
     * @throws DerbyException
     */
    public function getDefinition()
    {
        return $this->adapter->getContentDetailsField($this->getKey(), 'definition');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.caption
     * True if video has captions
     * @return bool
     * @throws DerbyException
     */
    public function hasCaption()
    {
        if ($this->adapter->getContentDetailsField($this->getKey(), 'caption') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.licensedContent
     * True if video is licensed
     * @return bool
     * @throws DerbyException
     */
    public function isLicensedContent()
    {
        if ($this->adapter->getContentDetailsField($this->getKey(), 'licensedContent') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.embeddable
     * True if video is embeddable
     * @return bool
     * @throws DerbyException
     */
    public function isEmbeddable()
    {
        if ($this->adapter->getStatusField($this->getKey(), 'embeddable') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.license
     * Returns the license of the video
     * @return mixed
     * @throws DerbyException
     */
    public function getLicense()
    {
        return $this->adapter->getStatusField($this->getKey(), 'license');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.privacyStatus
     * Returns the privacy status of the video
     * @return mixed
     * @throws DerbyException
     */
    public function getPrivacyStatus()
    {
        return $this->adapter->getStatusField($this->getKey(), 'privacyStatus');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.publicStatsViewable
     * Returns true if the stats are publicly visible
     * @return mixed
     * @throws DerbyException
     */
    public function isPublicStatusViewable()
    {
        if ($this->adapter->getStatusField($this->getKey(), 'publicStatsViewable') == 'true') {
            return true;
        }

        return false;
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.viewCount
     * @return int
     * @throws DerbyException
     */
    public function getViewCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'viewCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.likeCount
     * @return int
     * @throws DerbyException
     */
    public function getLikeCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'likeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.dislikeCount
     * @return int
     * @throws DerbyException
     */
    public function getDislikeCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'dislikeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.favoriteCount
     * @return int
     * @throws DerbyException
     */
    public function getFavoriteCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'favoriteCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.commentCount
     * @return int
     * @throws DerbyException
     */
    public function getCommentCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'commentCount');
    }

    /**
     * @return boolean
     */
    public function exists()
    {
        return $this->adapter->exists($this->getKey());
    }

    /**
     * Get adapter
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        return $this->mediaKey;
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     * @throws DerbyException
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        if (!$adapter instanceof YouTubeVideoAdapter) {
            throw new DerbyException('Invalid Adapter');
        }
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @param $mediaKey
     * @return $this
     */
    public function setKey($mediaKey)
    {
        $this->mediaKey = $mediaKey;

        return $this;
    }

    /**
     * Refresh data from google
     */
    public function refresh()
    {
        $this->adapter->refresh($this->getKey());
    }

}

