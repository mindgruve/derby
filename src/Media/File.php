<?php

namespace Derby\Media;

use Derby\Adapter\FileAdapterInterface;
use Derby\Exception\DerbyException;
use Derby\Media\File\LocalFile;

class File extends Media implements FileInterface
{

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
     * @param $mediaKey
     * @param FileAdapterInterface $adapter
     * @param string $tmpDirectory
     */
    public function __construct($mediaKey, FileAdapterInterface $adapter, $tmpDirectory = '/tmp/derby')
    {
        $this->tmpDirectory = $tmpDirectory;
        $this->adapter = $adapter;
        parent::__construct($mediaKey, $adapter);
    }

    /**
     * Read data from file
     * @return bool|string if cannot read content
     * @throws DerbyException
     */
    public function read()
    {
        if (!$this->exists()) {
            throw new DerbyException('File does not exist');
        }

        return $this->adapter->read($this->mediaKey);
    }

    /**
     * Write data to file
     * @param $data
     * @return integer|boolean The number of bytes that were written into the file
     */
    public function write($data)
    {
        return $this->adapter->write($this->mediaKey, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        return $this->adapter->delete($this->mediaKey);
    }

    /**
     * {@inheritDoc}
     */
    public function rename($newKey)
    {
        $success = $this->adapter->rename($this->mediaKey, $newKey);

        if ($success) {
            $this->mediaKey = $newKey;
        }

        return $success;
    }

    /**
     * {@inheritDoc}
     */
    public function copy($newKey)
    {
        $success = $this->adapter->copy($this->mediaKey, $newKey);

        return $success;
    }

    /**
     * @return null|string
     */
    public function getFileExtension()
    {
        if (strpos($this->mediaKey, '.') === false) {
            return null;
        }

        $fileParts = explode('.', $this->mediaKey);

        return array_pop($fileParts);
    }

    public function getKeyWithExtension($ext)
    {
        if (!$ext) {
            return $this->getKey();
        }

        $currentExt = $this->getFileExtension();
        $currentKey = $this->getKey();

        if (!$currentExt) {
            return $this->rename($currentKey.'.'.$ext);
        }

        $fileParts = explode('.', $this->mediaKey);
        array_pop($fileParts);
        $fileParts[] = $ext;

        return implode('.', $fileParts);
    }

    public function setFileExtension($ext)
    {
        if (!$ext) {
            return null;
        }

        $newFileName = $this->getKeyWithExtension($ext);

        return $this->rename($newFileName);
    }

    /**
     * @param string $newMediaKey
     * @param null $directory
     * @return LocalFile
     */
    public function copyToLocal($newMediaKey = null, $directory = null)
    {
        if (!$newMediaKey) {
            $newMediaKey = uniqid().'.'.$this->getFileExtension();
        }

        if (!$directory) {
            $directory = $this->tmpDirectory.'/'.uniqid();
        }

        $file = new LocalFile($newMediaKey, $directory, true);
        $file->write($this->read());

        return $file;
    }
}