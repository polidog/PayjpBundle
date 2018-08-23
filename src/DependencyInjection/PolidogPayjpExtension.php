<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class PolidogPayjpExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('polidog.web_pay.public_key', $config['public_key']);
        $container->setParameter('polidog.web_pay.secret_key', $config['secret_key']);

        if (isset($config['webhook']) && is_array($config['webhook'])) {
            $container->setParameter('polidog.web_pay.webhook.token', $config['webhook']['token']);
            $container->setParameter('polidog.web_pay.webhook.path', $config['webhook']['path']);
        } else {
            $container->setParameter('polidog.web_pay.webhook.token', null);
            $container->setParameter('polidog.web_pay.webhook.path', null);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
