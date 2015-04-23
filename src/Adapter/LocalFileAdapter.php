<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Adapter;
use Gaufrette\Adapter\Local;

/**
 * Derby\Adapter\LocalFileAdapter
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class LocalFileAdapter extends GaufretteAdapter implements LocalFileAdapterInterface
{
    /**
     * Base directory where file is located
     * @var string
     */
    private $baseDirectory;

    /**
     * {@inheritDoc}
     */
    public function __construct($baseDirectory, $create = false, $mode = 0777)
    {
        $this->baseDirectory = $baseDirectory;
        parent::__construct(new Local($baseDirectory, $create, $mode));
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseDirectory()
    {
        return $this->baseDirectory;
    }
}