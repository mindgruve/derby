<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Config;
use Derby\Exception\ImproperLocalMediaException;
use Derby\Media\LocalFile;

/**
 * Derby\Media\LocalFileHelper
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */
class LocalFileHelper
{
    /**
     * @var Config
     */
    private $config;

    /**
     * Local cache
     * @var array
     */
    private $cache = [];

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->setConfig($config);
    }

    /**
     * Get config
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set config
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        // setting new config clears cache
        $this->cache = [];
    }

    /**
     * Build a local file object for a key and local adapter
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @param mixed|null $data Optional data to write to file
     * @return LocalFileInterface
     * @throws ImproperLocalMediaException
     */
    public function buildFile($key, LocalFileAdapterInterface $adapter, $data = null)
    {
        $local = new LocalFile($key, $adapter);

        if ($data) {
            $local->write($data);
        }

        return $this->convertFile($local);
    }

    /**
     * Convert file object to proper type
     * @param LocalFileInterface $file
     * @return LocalFileInterface
     * @throws ImproperLocalMediaException
     */
    public function convertFile(LocalFileInterface $file)
    {
        // build cache if we don't have it. this is just a simple optimization
        // to avoid running the same loops for loopkups.
        if (!isset($this->cache['media'])) {
            $this->cache['media'] = array(
                'mime_types' => [],
                'extensions' => []
            );

            $cfg = $this->config->getConfig();

            foreach ($cfg['derby']['media'] as $m) {
                foreach ($m['mime_types'] as $type) {
                    $this->cache['media']['mime_types'][$type] = $m['class'];
                }

                foreach ($m['extensions'] as $e) {
                    $this->cache['media']['extensions'][$e] = $m['class'];
                }
            }
        }

        // if file exists, attempt to determine its type and return
        // appropriate representation of it otherwise use generic.
        if ($file->exists()) {
            $extension = $file->getFileExtension();
            $mimeType = $file->getMimeType();

            // default class we'll load if no match on mime or extension
            $fileClass = 'Derby\\Media\\LocalFile';

            // search for class by mime or extension
            if (isset($this->cache['media']['mime_types'][$mimeType])) {
                $fileClass = $this->cache['media']['mime_types'][$mimeType];
            } elseif (isset($this->cache['media']['extensions'][$extension])) {
                $fileClass = $this->cache['media']['extensions'][$extension];
            }

            $file = new $fileClass($file->getKey(), $file->getAdapter());

            if (!$file instanceof LocalFileInterface) {
                throw new ImproperLocalMediaException(sprintf('Local file object "%s" was loaded but it must implement Derby\Media\LocalFileInterface', get_class($file)));
            }
        }

        return $file;
    }
}