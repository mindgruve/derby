<?php

namespace Derby\Config;

use Derby\ConfigInterface;
use Symfony\Component\Yaml\Parser;
use Derby\Exception\InvalidConfigException;

class YamlConfig implements ConfigInterface
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

        if (!$this->isValid()) {
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

    public function setConfig(array $config)
    {
        $this->config = $config;

        if (!$this->isValid()) {
            throw new InvalidConfigException('Invalid config values');
        }
    }

    /**
     * Is the config valid
     * @return bool
     */
    public function isValid()
    {
        // although our default config has more settings, the only hard dependency
        // is [derby][media] and [derby][defaults][tmp_path] at the moment. Anything else isn't
        // used and not required yet.
        // @todo I think we should look into symfony's tree builder or options resolver

        if (!isset($this->config['derby']['defaults']['tmp_path'])) {
            return false;
        }

        if (!isset($this->config['derby']['media'])) {
            return false;
        }

        foreach ($this->config['derby']['media'] as $m) {
            if (!isset($m['factory'], $m['extensions'], $m['mime_types'])) {
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
        return __DIR__ . '/../../config/media_config.yml';
    }
}