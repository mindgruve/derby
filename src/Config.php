<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby;
use Symfony\Component\Yaml\Parser;
use Derby\Exception\InvalidConfigException;

/**
 * Derby\Config
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class Config
{
    /**
     * Local instances
     *
     * Yes these are singletons based on the config path.
     * Singletons are ok *sometimes*. Relax, ok!
     *
     * @var array
     */
    private static $instances = [];

    /**
     * Config
     * @var array
     */
    private $config = [];

    /**
     * @param string|null $configPath
     *
     * Use the self::create() factory method instead of direct constructor.
     *
     */
    protected function __construct($configPath = null)
    {
        $this->load($configPath ?: self::getDefaultConfigPath());
    }

    /**
     * Factory method to create a config object
     * @param string|null $configPath
     * @param bool $forceReload
     * @return self
     */
    public static function create($configPath = null, $forceReload = false)
    {
        $configPath = $configPath ?: self::getDefaultConfigPath();

        if (!isset(self::$instances[$configPath]) || $forceReload) {
            self::$instances[$configPath] = new self($configPath);
        }

        return self::$instances[$configPath];
    }

    /**
     * Load media config
     * @param string $configPath
     * @throws InvalidConfigException If config invalid
     */
    public function load($configPath)
    {
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents($configPath));

        if (!$this->isConfigValid()) {
            throw new InvalidConfigException('Invalid config values');
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Is the config valid
     * @return bool
     */
    public function isConfigValid()
    {
        // although our default config has more settings, the only hard dependency
        // is [derby][media] at the moment. Anything else isn't used and not required yet.

        if (!isset($this->config['derby']['media'])) {
            return false;
        }

        foreach ($this->config['derby']['media'] as $m) {
            if (!isset($m['class'], $m['extensions'], $m['mime_types'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get default config path
     * @return string
     */
    public static function getDefaultConfigPath()
    {
        return __DIR__.'/../config/media_config.yml';
    }
}