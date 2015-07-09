<?php

namespace Derby\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class MediaValidation implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('derby');

        $rootNode
            ->children()
                ->arrayNode('defaults')
                    ->children()
                        ->scalarNode('tmp_path')->end()
                        ->scalarNode('media')->end()
                        ->scalarNode('file')->end()
                        ->scalarNode('embed')->end()
                        ->scalarNode('group')->end()
                    ->end()
                ->end()
                ->arrayNode('thumbnails')
                    ->children()
                        ->scalarNode('library')->end()
                        ->scalarNode('adapter')->end()
                    ->end()
                ->end()
                ->arrayNode('adapters')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('class')->end()
                            ->scalarNode('name')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('media')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('factory')->end()
                            ->arrayNode('extensions')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('mime_types')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}