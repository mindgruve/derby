<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\AdapterInterface;
use Derby\Media;
use Derby\MediaInterface;
use Derby\Adapter\ReadOnlyRemoteFileAdapterInterface;

/**
 * Derby\Media\ReadOnlyRemoteFile
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class ReadOnlyRemoteFile extends Media implements ReadOnlyRemoteFileInterface
{
    const TYPE_MEDIA_READ_ONLY_REMOTE_FILE = 'MEDIA\READ_ONLY_REMOTE_FILE';

    /**
     * @param $key
     * @param ReadOnlyRemoteFileAdapterInterface $adapter
     */
    public function __construct($key, ReadOnlyRemoteFileAdapterInterface $adapter)
    {
        parent::__construct($key, $adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_READ_ONLY_REMOTE_FILE;
    }

    /**
     * {@inheritDoc}
     */
    public function exists()
    {
        // temporarily set context to use head request
        stream_context_set_default([
            'http' => [
                'method' => 'HEAD'
            ]
        ]);

        $headers = get_headers($this->getUrl(), 1);

        // set context method back to get
        stream_context_set_default([
            'http' => [
                'method' => 'GET'
            ]
        ]);

        return stristr($headers[0], '200');
    }

    /**
     * {@inheritDoc}
     */
    public function read()
    {
        if (!$this->exists()) {
            return null;
        }

        return file_get_contents($this->getUrl());
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {
        $url = $this->getUrl();

        $slashPos = strrpos($url, '/');
        $dotPos = strrpos($url, '.');

        if ($dotPos === false || $dotPos < $slashPos) {
            return null;
        }

        return substr($url, $dotPos+1);
    }
}