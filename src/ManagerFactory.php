<?php

namespace Derby;

class ManagerFactory
{

    public static function build(ConfigInterface $config)
    {
        $config = $config->getConfig();
        $manager = new Manager();
        foreach ($config['derby']['media'] as $m) {
            $factory = $m['factory'];
            $manager->registerFileFactory(new $factory($m['extensions'], $m['mime_types']));
        }
        return $manager;
    }

}