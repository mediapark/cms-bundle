<?php

namespace Mp\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mp_cms');

        $rootNode->children()
            ->arrayNode('uploads')
            ->children()->scalarNode('keep_on_change')->end()
            ->end()->end()
            ->arrayNode('session')->isRequired()
            ->children()->scalarNode('class')->isRequired()->end()
            ->end()->end()
        ->end();

        return $treeBuilder;
    }
}
