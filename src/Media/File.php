<?php

namespace Derby\Media;

use Derby\Adapter\FileAdapterInterface;
use Derby\Media;
use Derby\Media\File\LocalFile;

class File extends Media implements FileInterface
{
    const TYPE_MEDIA_FILE = 'MEDIA/FILE';

    /**
     * @var FileAdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $tmpDirectory;

    /**
     * @var LocalFile
     */
    protected $tmpFile;


    /**
     * @param $key
     * @param FileAdapterInterface $adapter
     * @param string $tmpDirectory
     */
    public function __construct($key, FileAdapterInterface $adapter, $tmpDirectory = '/tmp/derby')
    {
        $this->tmpDirectory = $tmpDirectory;
        $this->adapter = $adapter;
        parent::__construct($key, $adapter);
    }


    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_FILE;
    }

    /**
     * Read data from file
     * @return bool|string if cannot read content
     * @throws \Exception
     */
    public function read()
    {
        if(!$this->exists()){
            throw new \Exception('File does not exist');
        }

        return $this->adapter->read($this->key);
    }

    /**
     * Write data to file
     * @param $data
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function write($data)
    {
        return $this->adapter->write($this->key, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        return $this->adapter->delete($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function rename($newKey)
    {
        $success = $this->adapter->rename($this->key, $newKey);

        if ($success) {
            $this->key = $newKey;
        }

        return $success;
    }

    /**
     * {@inheritDoc}
     */
    public function copy($newKey)
    {
        $success = $this->adapter->copy($this->key, $newKey);

        return $success;
    }

    /**
     * @return null|string
     */
    public function getFileExtension()
    {
        // @todo we are going to want make this smarter. A "." should be the last char followed by letters.

        if (strpos($this->key, '.') === false) {
            return null;
        }

        return substr($this->key, strrpos($this->key, '.') + 1, strlen($this->key));
    }

    /**
     * @param string $key
     * @param null $directory
     * @return LocalFile
     */
    public function copyToLocal($key = null, $directory = null)
    {
        if(!$key){
            $key = uniqid().'.'.$this->getFileExtension();
        }

        if (!$directory) {
            $directory = $this->tmpDirectory . '/' . uniqid();
        }

        $file = new LocalFile($key, $directory, true);
        $file->write($this->read());
        return $file;
    }
}