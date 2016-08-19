<?php

namespace Derby\Media\File;

use Derby\Adapter\FileAdapter;
use Derby\Media\File;
use Gaufrette\Adapter\Local;

class LocalFile extends File
{

    /**
     * @var Local
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $baseDirectory;


    public function __construct($mediaKey, $baseDirectory, $create = false, $mode = 0777)
    {

        $this->baseDirectory = $baseDirectory;
        $this->adapter = new FileAdapter('derby.local', new Local($baseDirectory, $create, $mode));

        parent::__construct($mediaKey, $this->adapter);
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

        $mediaKey = $this->getKey();

        // I'm sure this can be optimized!
        // We're just accounting for leading or trailing /'s

        $base = $this->getBaseDirectory();
        $baselen = strlen($base);

        if (strrpos($base, '/') === (int)$baselen - 1) {
            $base = substr($base, 0, $baselen - 1);
        }

        if ($pos = strpos($mediaKey, '/') === (int)0) {
            $mediaKey = substr($mediaKey, $pos, strlen($mediaKey));
        }

        return $base.'/'.$mediaKey;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->adapter->mimeType($this->mediaKey);
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

}