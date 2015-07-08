<?php

namespace Derby\Adapter\File;

use Derby\Adapter\CdnAdapterInterface;
use Derby\Adapter\LocalFileAdapter;

class LocalCdnAdapter extends LocalFileAdapter implements CdnAdapterInterface
{

    protected $webPath;

    public function __construct($basePath, $webPath, $create = false, $mode = 0777)
    {
        $this->webPath = $webPath;

        parent::__construct($basePath, $create, $mode);
    }

    public function getUrl($key)
    {
        return $this->webPath . $key;
    }


}