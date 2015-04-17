<?php

namespace Derby\Media\KeyProvider;

use Derby\Interfaces\FileInterface;
use Derby\Interfaces\KeyProviderInterface;
use Derby\Utility\Slugize;

class ChronologicalKey implements KeyProviderInterface
{
    public function generateKey(FileInterface $file = null)
    {
        return date('Y/m/') . Slugize::slugize($file->getLabel()).'.'.$file->getExtension();
    }
}
