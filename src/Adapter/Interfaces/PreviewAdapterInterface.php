<?php

namespace Derby\Adapter\Interfaces;

interface PreviewAdapterInterface extends AdapterInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function getPreview($key);
}
