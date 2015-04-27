<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Media;

/**
 * Derby\Media\RemoteFile
 *
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class RemoteFile extends Media implements RemoteFileInterface
{
    /**
     * @param $key
     * @param RemoteFileAdapterInterface $adapter
     */
    public function __construct($key, RemoteFileAdapterInterface $adapter)
    {
        parent::__construct($key, $adapter);
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_MEDIA_REMOTE_FILE;
    }

    /**
     * Read data from file
     * @return string|boolean if cannot read content
     */
    public function read()
    {
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
    public function exists()
    {
        return $this->adapter->exists($this->key);
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
     * @return LocalFileInterface
     */
    public function download()
    {
        $configObj = $this->adapter->getConfig();
        $config = $configObj->getConfig();

        // use general file type to manage file download
        $local = new LocalFile($this->getKey(), new LocalFileAdapter($config['derby']['defaults']['tmp_path']));
        $local->write($this->read());

        // create actual object representation of file type
        return LocalFileHelper::create($configObj)->buildFile($this->getKey(), $local->getAdapter());
    }
}
