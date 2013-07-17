<?php

namespace Mp\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MpCmsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if(isset($config['uploads'])) {
            $container->setParameter('cms.uploads.keep_on_change', $config['uploads']['keep_on_change']);
        } else {
            $container->setParameter('cms.uploads.keep_on_change', false);
        }
        $container->setParameter('cms.session.class', $config["session"]["class"]);
        $loader->load('services.yml');
    }
}
