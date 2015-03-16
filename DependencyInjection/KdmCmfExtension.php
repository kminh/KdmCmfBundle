<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

use Kdm\CmfBundle\Doctrine\Phpcr\Page;

/**
 * Override Symfony CMF configuration
 *
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class KdmCmfExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        // prepend CmfRoutingBundle config
        /* $prependConfig['dynamic']['persistence']['phpcr']['route_basepaths'] = array('/cms/routes'); */
        /* $container->prependExtensionConfig('cmf_routing', $prependConfig); */

        // prepend CmfSimpleCmsBundle config
        $prependConfig = [];
        $prependConfig['persistence']['phpcr']['document_class'] = Page::class;
        $container->prependExtensionConfig('cmf_simple_cms', $prependConfig);
    }

    protected function loadInternal(array $configs, ContainerBuilder $container)
    {
        // load service definitions and parameters
        $this->loadConfiguration($container);

        // load configuration
        if (isset($configs['templates'])) {
            $this->loadTemplates($configs['templates'], $container);
        }

        if (isset($configs['form_types'])) {
            $this->loadFormTypes($configs['form_types'], $container);
        }
    }

    protected function loadTemplates(array $templates, ContainerBuilder $container)
    {
        $container->setParameter('kdm.cmf.templates', $templates);
    }

    protected function loadFormTypes(array $formTypes, ContainerBuilder $container)
    {
        $container->setParameter('kdm.cmf.form_types', $formTypes);
    }

    protected function loadConfiguration(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('parameters.yml');
        $loader->load('services.yml');
    }
}
