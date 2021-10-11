<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PolidogPayjpExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('polidog.web_pay.public_key', $config['public_key']);
        $container->setParameter('polidog.web_pay.secret_key', $config['secret_key']);
        $container->setParameter('polidog.web_pay.webhook_token', $config['webhook_token']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
