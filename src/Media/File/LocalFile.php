<?php

namespace Derby\Media\File;

use Derby\Adapter\FileAdapter;
use Derby\Media\File;
use Gaufrette\Adapter\Local;

class LocalFile extends File
{

    const TYPE_MEDIA_FILE_LOCAL = 'MEDIA/FILE/IMAGE';

    /**
     * @var Local
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $baseDirectory;


    public function __construct($key, $baseDirectory, $create = false, $mode = 0777)
    {

        $this->baseDirectory = $baseDirectory;
        $this->adapter = new FileAdapter(new Local($baseDirectory, $create, $mode));

        parent::__construct($key, $this->adapter);
    }

    /**
     * @return \Derby\Adapter\FileAdapterInterface|string
     */
    public function getBaseDirectory()
    {
        return $this->baseDirectory;
    }

    /**
     * @return string
     */
    public function getPath()
    {

        $key = $this->getKey();

        // I'm sure this can be optimized!
        // We're just accounting for leading or trailing /'s

        $base = $this->getBaseDirectory();
        $baselen = strlen($base);

        if (strrpos($base, '/') === (int)$baselen - 1) {
            $base = substr($base, 0, $baselen - 1);
        }

        if ($pos = strpos($key, '/') === (int)0) {
            $key = substr($key, $pos, strlen($key));
        }

        return $base . '/' . $key;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->adapter->mimeType($this->key);
    }

    /**
     * @return int|null
     */
    public function getSize()
    {
        if (!$this->exists()) {
            return null;
        }

        return filesize($this->getPath($this->getKey()));
    }

    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE_LOCAL;
    }

}