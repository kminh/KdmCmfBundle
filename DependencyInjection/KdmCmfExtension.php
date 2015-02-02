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

/**
 * Override Symfony CMF configuration
 *
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class KdmCmfExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $prependConfig['dynamic']['persistence']['phpcr']['route_basepaths'] = array('/cms/routes');
        $container->prependExtensionConfig('cmf_routing', $prependConfig);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
    }

    public function getConfiguration(array $configs, ContainerBuilder $container)
    {
    }
}