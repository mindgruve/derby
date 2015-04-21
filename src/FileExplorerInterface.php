<?php

namespace Derby;

use Derby\Media\FileInterface;
use Derby\Media\SearchInterface;

interface FileExplorerInterface extends MediaExplorerInterface
{

    public function copyFile(FileInterface $file, array $targetAdapters);

    public function removeFiles(SearchInterface $search, array $targetAdapters);

    public function renameFile(FileInterface $file, array $targetAdapters);

    public function replaceFile(FileInterface $file, array $targetAdapters);

}
