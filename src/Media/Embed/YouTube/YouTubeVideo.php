<?php

namespace Derby\Media\Embed\YouTube;

use Derby\AdapterInterface;
use Derby\Media;
use Derby\Adapter\YouTube\YouTubeVideoAdapter;
use Derby\MediaInterface;

class YouTubeVideo implements MediaInterface
{

    const TYPE_MEDIA_EMBED_YOUTUBE_VIDEO = 'MEDIA/EMBED/YOUTUBE/VIDEO';

    /**
     * @param $key
     * @param YouTubeVideoAdapter $adapter
     */
    public function __construct($key, YouTubeVideoAdapter $adapter)
    {
        $this->key = $key;
        $this->adapter = $adapter;
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
     * @throws \Exception
     */
    public function getCategoryId()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'categoryId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.publishedAt
     * @return mixed
     * @throws \Exception
     */
    public function getPublishedAt()
    {
        return new \DateTime($this->adapter->getSnippetField($this->getKey(), 'publishedAt'));
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelId
     * @return mixed
     * @throws \Exception
     */
    public function getChannelId()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'channelId');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.channelTitle
     * @return mixed
     * @throws \Exception
     */
    public function getChannelTitle()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'channelTitle');
    }


    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.title
     * @return mixed
     * @throws \Exception
     */
    public function getTitle()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'title');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.description
     * @return mixed
     * @throws \Exception
     */
    public function getDescription()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'description');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.tags
     * @return mixed
     * @throws \Exception
     */
    public function getTags()
    {
        return $this->adapter->getSnippetField($this->getKey(), 'tags');
    }

    /**
     * Get Duration
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.duration
     * @return string
     * @throws \Exception
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
     * @throws \Exception
     */
    public function getDefinition()
    {
        return $this->adapter->getContentDetailsField($this->getKey(), 'definition');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#contentDetails.caption
     * True if video has captions
     * @return bool
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
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
     * @throws \Exception
     */
    public function getLicense()
    {
        return $this->adapter->getStatusField($this->getKey(), 'license');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.privacyStatus
     * Returns the privacy status of the video
     * @return mixed
     * @throws \Exception
     */
    public function getPrivacyStatus()
    {
        return $this->adapter->getStatusField($this->getKey(), 'privacyStatus');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#status.publicStatsViewable
     * Returns true if the stats are publicly visible
     * @return mixed
     * @throws \Exception
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
     * @throws \Exception
     */
    public function getViewCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'viewCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.likeCount
     * @return int
     * @throws \Exception
     */
    public function getLikeCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'likeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.dislikeCount
     * @return int
     * @throws \Exception
     */
    public function getDislikeCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'dislikeCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.favoriteCount
     * @return int
     * @throws \Exception
     */
    public function getFavoriteCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'favoriteCount');
    }

    /**
     * https://developers.google.com/youtube/v3/docs/videos#snippet.statistics.commentCount
     * @return int
     * @throws \Exception
     */
    public function getCommentCount()
    {
        return $this->adapter->getStatisticsField($this->getKey(), 'commentCount');
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_EMBED_YOUTUBE_VIDEO;
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
        return $this->key;
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     * @throws \Exception
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        if (!$adapter instanceof YouTubeVideoAdapter) {
            throw new \Exception('Invalid Adapter');
        }
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Set key
     * @param $key
     * @return mixed
     */
    public function setKey($key)
    {
        if ($this->getKey() != null) {
            $this->key = $key;
            $this->adapter->load($key);
        }
    }
}

