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
     * Config
     * @var array
     */
    private $config = [];

    /**
     * @param string|null $configPath
     */
    public function __construct($configPath = null)
    {
        $this->load($configPath ?: self::getDefaultConfigPath());
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
        // is [derby][media] and [derby][tmp_path] at the moment. Anything else isn't
        // used and not required yet.
        // @todo I think we should look into symfony's tree builder or options resolver

        if (!isset($this->config['derby']['tmp_path'])) {
            return false;
        }

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