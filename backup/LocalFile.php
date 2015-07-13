<?php
/**
 * Created by PhpStorm.
 * User: ksimpson
 * Date: 7/13/15
 * Time: 11:57 AM
 */

namespace Derby\Media;

use Gaufrette\Adapter\Local;

class LocalFile extends File implements LocalFileInterface
{

    /**
     * {@inheritDoc}
     */
    public function getMimeType()
    {
        return $this->adapter->getGaufretteAdapter()->mimeType($this->key);
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {
        if (!$this->exists()) {
            return null;
        }

        return filesize($this->getPath());
    }

    /**
     * {@inheritDoc}
     */
    public function getPath($key = null)
    {
        return $this->adapter->getPath($this->key);
    }

}