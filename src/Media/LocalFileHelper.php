<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Media;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Config;
use Derby\Exception\ImproperLocalMediaException;
use Derby\Media\LocalFile;
use Derby\MediaInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Parser;

/**
 * Derby\Media\LocalFileHelper
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
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
     * Simple factory method
     * @param Config $config
     * @return LocalFileHelper
     */
    public static function create(Config $config)
    {
        return new self($config);
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
     * Build a local media object for a key and local adapter
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @return MediaInterface
     */
    public function buildMedia($key, LocalFileAdapterInterface $adapter)
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

        $path = $adapter->getPath($key);

        $extension = substr($key, strrpos($key, '.')+1, strlen($key));

        $f = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $f->file($path);

        // default class we'll load if no match on mime or extension
        $mediaClass = 'Derby\\Media\\LocalFile';

        // search for class by mime or extension
        if (isset($this->cache['media']['mime_types'][$mimeType])) {
            $mediaClass = $this->cache['media']['mime_types'][$mimeType];
        } elseif (isset($this->cache['media']['extensions'][$extension])) {
            $mediaClass = $this->cache['media']['extensions'][$mimeType];
        }

        $mediaObj = new $mediaClass($key, $adapter);

        if (!$mediaObj instanceof LocalFileInterface) {
            throw new ImproperLocalMediaException('A matched local media type class was found but it does not implement the proper LocalFileInterface interface');
        }

        return $mediaObj;
    }
}