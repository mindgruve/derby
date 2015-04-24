<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;

use Derby\Adapter\LocalFileAdapterInterface;
use Derby\Media\LocalFile;
use Symfony\Component\Yaml\Parser;

/**
 * Derby\LocalMediaHelper
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class LocalMediaHelper
{
    /**
     * Local instances
     * @var array
     */
    private static $instances = [];

    /**
     * Media config
     * @var array
     */
    private $mediaConfig = [];

    /**
     * @param string|null $configPath
     */
    public function __construct($configPath = null)
    {
        $this->loadMediaConfig($configPath ?: __DIR__.'/../config/media_config.yml');
    }

    /**
     * Build and return helper object
     * @param string|null $configPath
     * @return LocalMediaHelper
     */
    public static function create($configPath = null)
    {
        if (!isset(self::$instances[$configPath])) {
            self::$instances[$configPath] = new self($configPath);
        }

        return self::$instances[$configPath];
    }

    /**
     * Build a locamedia object for a key and local adapter
     * @param $key
     * @param LocalFileAdapterInterface $adapter
     * @return MediaInterface
     */
    public function buildMedia($key, LocalFileAdapterInterface $adapter)
    {
        // @todo actual code. for now just create a generic local file
        // $path = $adapter->getPath($key);
        // ...check type of media here and load appropriate media object

        return new LocalFile($key, $adapter);
    }

    /**
     * Load media config
     * @param string $configPath
     */
    private function loadMediaConfig($configPath)
    {
        $parser = new Parser();
        $this->mediaConfig = []; // @todo $parser->parse(file_get_contents($configPath));
    }
}