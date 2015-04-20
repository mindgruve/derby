<?php

namespace Derby\Media;

use Derby\Media;

class File extends Media implements FileInterface
{

    /**
     * @var string
     */
    protected $key;

    /**
     * @var FileSystem
     */
    protected $fileSystem;
    
    public function __construct(
        $key,
        Filesystem $filesystem,
        MetaData  $metaData
    )
    {
        $this->key       = $key;
        $this->fileSystem = $filesystem;
        
        parent::__construct($metaData);
    }

    /**
     * @return string
     */
    public function getMediaType(){
        return self::TYPE_MEDIA_FILE;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return bool
     */
    public function remove()
    {
        $response = $this->fileSystem->delete($this->getKey());
        if ($response) {
            $this->metaData->setDateModified(new \DateTime());
        }


        return $response;
    }

    /**
     * @return boolean
     */
    public function read()
    {
        return $this->fileSystem->read($this->getKey());
    }

    /**
     * @param $data
     * @return mixed
     */
    public function write($data)
    {
        $response = $this->fileSystem->write($this->getKey(), $data);
        if ($response) {
            $this->metaData->setDateModified(new \DateTime());
        }

        return $response;
    }

    /**
     * @param $newKey
     * @return bool
     */
    public function rename($newKey)
    {
        $response = $this->fileSystem->rename($this->getKey(), $newKey);

        if ($response) {
            $this->metaData->setDateModified(new \DateTime());
        }

        return $response;
    }

}
