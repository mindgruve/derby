<?php

namespace Derby\Config;

use Derby\Adapter\CdnAdapterInterface;
use Derby\ConfigInterface;
use Derby\Exception\InvalidConfigException;
use Mockery\CountValidator\Exception;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\Definition\Processor;

class YamlConfig implements ConfigInterface
{

    protected $config = array();

    /**
     * @param array $configPaths
     */
    public function __construct(array $configPaths = array())
    {
        $config = array();
        $configPaths = ($configPaths) ? $configPaths : array(realpath(__DIR__ . '/../../config/media.yml'));

        foreach ($configPaths as $configPath) {
            if (file_exists($configPath)) {
                $config = array_merge($config, Yaml::parse(file_get_contents($configPath)));
            } else {
                throw new Exception('File does not exist - ' . $configPath);
            }
        }

        $this->setConfig($config);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @throws InvalidConfigException
     */
    public function validate(array $config = array())
    {

        $config = ($config) ? $config['derby'] : $this->config['derby'];
        $configs = array($config);

        $processor = new Processor();
        $validation = new MediaValidation();

        try {
            $processor->processConfiguration(
                $validation,
                $configs
            );
        } catch (\Exception  $e) {
            throw new InvalidConfigException($e->getMessage());
        }


        $requiredClasses = array(
            $config['defaults']['media'],
            $config['defaults']['file'],
            $config['defaults']['embed'],
            $config['defaults']['group'],
            $config['thumbnails']['library'],
            $config['thumbnails']['adapter'],
        );

        foreach($config['adapters'] as $adapter){
            $requiredClasses[] = $adapter['class'];
        }

        foreach($config['media'] as $adapter){
            $requiredClasses[] = $adapter['factory'];
        }

        // confirm that all the classes defined in the configuration exist
        foreach ($requiredClasses as $class) {
            if (!class_exists($class)) {
                throw new InvalidConfigException('Class not defined - ' . $class);
            }
        }

        // validate interfaces
        if(!in_array('Derby\Adapter\CdnAdapterInterface', class_implements($config['thumbnails']['adapter']))){
            throw new InvalidConfigException('Class ('.$config['thumbnails']['adapter'].')should be an instance of Derby\Adapter\CdnAdapterInterface');
        }

        foreach($config['adapters'] as $adapter){
            if(!in_array('Derby\AdapterInterface', class_implements($adapter['class']))){
                throw new InvalidConfigException('Class ('.$adapter['class'].')should be an instance of Derby\AdapterInterface');
            };
        }

        foreach($config['media'] as $media){
            if(!in_array('Derby\Media\LocalFileFactoryInterface', class_implements($media['factory']))){
                throw new InvalidConfigException('Class ('.$media['factory'].')should be an instance of Derby\Media\LocalFileFactoryInterface');
            };
        }

    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->validate($config);
        $this->config = $config;
    }
}