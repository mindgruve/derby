<?php

namespace Derby\Adapter\Interfaces;

use Derby\AdapterInterface;

interface PreviewAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function getPreview($key);
}
