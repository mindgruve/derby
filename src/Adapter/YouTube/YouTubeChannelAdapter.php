<?php

namespace Derby\Adapter\YouTube;

use Derby\Adapter\CollectionAdapterInterface;
use Derby\Media\YouTube\YouTubeChannel;
use Derby\MediaInterface;
use Derby\Exception\MediaNotFoundException;

class YouTubeChannelAdapter implements CollectionAdapterInterface
{

    const ADAPTER_YOU_TUBE_CHANNEL = 'ADAPTER\EMBED\YOU_TUBE_CHANNEL';

    /**
     * @var \Google_Client
     */
    protected $client;

    /**
     * @var \Google_Service_YouTube_Channel
     */
    protected $service;

    /**
     * @var array
     */
    protected $channels = array();

    /**
     * @var array
     */
    protected $videoIdsForChannel = array();

    /**
     * @var array
     */
    protected $videoCountForChannel = array();

    /**
     * @var YouTubeVideoAdapter
     */
    protected $videoAdapter;


    /**
     * @param \Google_Client $client
     */
    public function __construct(\Google_Client $client, YouTubeVideoAdapter $videoAdapter)
    {
        $this->client = $client;
        $this->service = new \Google_Service_YouTube($client);
        $this->videoAdapter = $videoAdapter;
    }


    /**
     * @param $key
     * @return boolean
     */
    public function exists($key)
    {
        $result = $this->service->channels->listChannels('id', array('id' => $key));

        return $result->count() == 0 ? false : true;
    }

    /**
     * @return string
     */
    public function getAdapterType()
    {
        return self::ADAPTER_YOU_TUBE_CHANNEL;
    }

    /**
     * Pull data again from Google
     * @param $key
     * @return MediaInterface
     * @throws MediaNotFoundException
     */
    public function refresh($key)
    {
        if (isset($this->channels[$key])) {
            unset($this->channels[$key]);
        }
        $this->loadChannelData($key);

        return $this->getMedia($key);
    }

    /**
     * Clear local cache
     */
    public function clearCache()
    {
        $this->channels = array();
        $this->videoCountForChannel = array();
        $this->videoIdsForChannel = array();
    }

    /**
     * Retrieves data from API
     * @throws MediaNotFoundException
     */
    protected function loadChannelData($key)
    {
        if (isset($this->channels[$key])) {
            return;
        }

        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $response = $this->service->channels->listChannels(
            'snippet,statistics,status,contentDetails',
            array('id' => $key)
        );
        $items = $response->getItems();
        if (count($items) && $items[0] instanceof \Google_Service_YouTube_Channel) {
            $this->channels[$key] = $items[0];
        } else {
            throw new MediaNotFoundException();
        }
    }

    protected function loadVideoData($key, $page = 1, $limit = 10)
    {
        if ($limit > 50) {
            throw new \Exception('YouTube limits the maximum number of results to 50');
        }

        if (isset($this->videoIdsForChannel[$key])) {
            return;
        }

        $this->youTubeService = new \Google_Service_YouTube($this->client);
        $search = $this->service->search;

        $currentPage = 1;
        $nextPageToken = null;
        while ($currentPage <= $page) {

            if (count($this->videoIdsForChannel) > ($currentPage * $limit)) {
                $currentPage++;
                continue;
            }

            $response = $search->listSearch(
                'id',
                array('channelId' => $key, 'type' => 'video', 'maxResults' => $limit, 'pageToken' => $nextPageToken)
            );

            if ($currentPage == 1) {
                $pageInfo = $response->getPageInfo();
                $this->videoCountForChannel[$key] = $pageInfo->getTotalResults();
            }

            foreach ($response->getItems() as $item) {
                $id = $item->getId()->getVideoId();
                $this->videoIdsForChannel[$key][] = $id;
            }

            $nextPageToken = $response->getNextPageToken();
            if (!$nextPageToken) {
                break;
            }

            $currentPage++;
        }
    }

    /**
     * @param $key
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function getItems($key, $page = 1, $limit = 10)
    {
        $this->loadChannelData($key);
        $this->loadVideoData($key, $page, $limit);

        $offset = ($page - 1) * $limit;
        $ids = array_slice($this->videoIdsForChannel[$key], $offset, $limit);

        $return = array();
        foreach ($ids as $id) {
            $return[] = $this->videoAdapter->getMedia($id);
        }

        return $return;
    }

    /**
     * @param $key
     * @return MediaInterface
     */
    public function getMedia($key)
    {
        return new YouTubeChannel($key, $this);
    }

    /**
     * Returns back true if $item is in collection
     * @param $key
     * @param MediaInterface $item
     * @return boolean
     */
    public function contains($key, MediaInterface $item)
    {
        $this->loadChannelData($key);

        $video = $this->videoAdapter->getMedia($item->getKey());

        if (!$video->exists()) {
            return false;
        }

        return $video->getChannelId() == $key;
    }

    /**
     * Returns the number of items in the collection
     * @param $key
     * @return int
     */
    public function count($key)
    {
        $this->loadChannelData($key);
        $this->loadVideoData($key, 1, 1);

        return $this->videoCountForChannel[$key];
    }
}