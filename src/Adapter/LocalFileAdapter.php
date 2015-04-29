<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Adapter;

use Derby\Config;
use Derby\Media\LocalFile;
use Derby\Media\LocalFileHelper;
use Gaufrette\Adapter\Local;

/**
 * Derby\Adapter\LocalFileAdapter
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class LocalFileAdapter extends AbstractGaufretteAdapter implements LocalFileAdapterInterface
{
    /**
     * Base path
     *
     * File location (key) will be relative to this path
     *
     * @var string
     */
    private $basePath;

    /**
     * {@inheritDoc}
     */
    public function __construct($basePath, $create = false, $mode = 0777)
    {
        $this->basePath = $basePath;
        parent::__construct(new Local($basePath, $create, $mode));
    }

    /**
     * {@inheritDoc}
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getPath($key)
    {
        // I'm sure this can be optimized!
        // We're just accounting for leading or trailing /'s

        $base = $this->getBasePath();
        $baselen = strlen($base);

        if (strrpos($base, '/') === (int)$baselen-1) {
            $base = substr($base, 0, $baselen-1);
        }

        if ($pos = strpos($key, '/') === (int)0) {
            $key = substr($key, $pos, strlen($key));
        }

        return $base.'/'.$key;
    }

    /**
     * {@inheritDoc}
     */
    public function getMedia($key)
    {
        return new LocalFile($key, $this);
    }
}
