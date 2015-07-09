<?php

namespace Derby;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ManagerFactory
{

    public static function build($configDir = null, $configFile = 'media.yml')
    {
        if (!$configDir) {
            $configDir = realpath(__DIR__ . '/../config/');
        }

        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load($configFile);

        $container->compile();

        $mediaManager = $container->get('media.manager');
        $taggedServices = $container->findTaggedServiceIds('media.factory');

        foreach ($taggedServices as $serviceKey => $tags) {
            $factory = $container->get($serviceKey);
            $priority = 10;

            foreach ($tags[0] as $tagKey => $tagValue) {
                if ($tagKey == 'priority') {
                    $priority = $tagValue;
                }
            }

            $mediaManager->registerFileFactory($factory, $priority);

        }

        return $mediaManager;
    }
}