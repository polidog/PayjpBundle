<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('polidog_payjp');
        $rootNode
            ->children()
            ->scalarNode('public_key')->defaultNull()->end()
            ->scalarNode('secret_key')->defaultNull()->end()
                ->arrayNode('webhook')
                    ->children()
                        ->scalarNode('token')->defaultNull()->end()
                        ->scalarNode('path')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
