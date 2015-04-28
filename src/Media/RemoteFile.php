<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapter;
use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Adapter\RemoteFileAdapterInterface;
use Derby\Media;

/**
 * Derby\Media\RemoteFile
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
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
     * {@inheritDoc}
     */
    public function download($key = null, LocalFileAdapter $adapter = null)
    {
        $configObj = $this->adapter->getConfig();
        $config = $configObj->getConfig();
        $key = $key ?: $this->getkey();
        $adapter = $adapter ?: new LocalFileAdapter($config['derby']['defaults']['tmp_path']);

        $helper = new LocalFileHelper($configObj);

        return $helper->buildFile(
            $key,
            $adapter,
            $this->read()
        );
    }
}
