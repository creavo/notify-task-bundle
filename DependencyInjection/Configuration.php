<?php

namespace Creavo\NotifyTaskBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('creavo_notify_task');

        $rootNode
            ->children()
                ->booleanNode('send_notification_immediately')->defaultFalse()->end()
                ->booleanNode('pushover_enabled')->defaultFalse()->end()
                ->scalarNode('pushover_api_token')->defaultNull()->end()
                ->booleanNode('email_enabled')->defaultFalse()->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
