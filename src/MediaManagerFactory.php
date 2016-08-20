<?php

namespace Derby;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MediaManagerFactory
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

        // register file factories
        $taggedServices = $container->findTaggedServiceIds('media.factory');
        foreach ($taggedServices as $serviceKey => $tags) {
            $factory = $container->get($serviceKey);

            $priority = null;
            foreach ($tags[0] as $tagKey => $tagValue) {
                if ($tagKey == 'priority') {
                    $priority = $tagValue;
                }
            }
            $mediaManager->registerMediaFactory($factory, $priority);
        }

        // register adapters
        $taggedServices = $container->findTaggedServiceIds('media.adapter');
        foreach ($taggedServices as $serviceKey => $tags) {
            $adapter = $container->get($serviceKey);
            $mediaManager->registerAdapter( $adapter);
        }

        return $mediaManager;
    }
}