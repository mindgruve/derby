<?php

namespace Derby\Media\Alias;

use Derby\Media\Alias;
use Derby\Media\FileInterface;
use Derby\Media\PublicAdapterInterface;
use Derby\Media\MetaData;

class FileAlias extends Alias implements FileInterface
{
    const TYPE_ALIAS_FILE = 'MEDIA\ALIAS\FILE';

    /**
     * @var FileInterface
     */
    protected $target;

    /**
     * @var MetaData
     */
    protected $metaData;

    public function __construct(
        FileInterface $target,
        MetaData $metaData
    ) {
        $this->target   = $target;
        $this->metaData = $metaData;

        parent::__construct($target, $metaData);
    }


    /**
     * @return string
     */
    public function getMediaType()
    {
        return self::TYPE_ALIAS_FILE;
    }

    /**
     * @return FileAlias
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->target->getKey();
    }

    /**
     * @param $newKey
     * @return mixed
     */
    public function rename($newKey)
    {
        return $this->target->rename($newKey);
    }

    /**
     * @return boolean
     */
    public function read()
    {
        return $this->target->read();
    }

    /**
     * @return bool
     */
    public function remove()
    {
        return $this->target->remove();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function write($data)
    {
        return $this->target->write($data);
    }

}
