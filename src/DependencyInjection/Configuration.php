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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('polidog_payjp');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('public_key')->defaultNull()->end()
                ->scalarNode('secret_key')->defaultNull()->end()
                ->scalarNode('webhook_token')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
