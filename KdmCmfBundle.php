<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass;

use Kdm\CmfBundle\DependencyInjection\Compiler\SymfonyCmfSimpleCmsCompilerPass;
use Kdm\CmfBundle\DependencyInjection\Compiler\SymfonyCmfRoutingCompilerPass;
use Kdm\CmfBundle\DependencyInjection\Compiler\SonataNewsCompilerPass;

/**
 * Provides all necessary functionality and extensions to bootstrap a new
 * website with Symfony CMF and SonataAdmin
 *
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class KdmCmfBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // override Symfony CMF and SonataAdmin configuration
        $this->_overrideConfiguration($container);

        // load bundle configuration
        $this->_loadConfiguration($container);
    }

    private function _overrideConfiguration(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['CmfSimpleCmsBundle'])) {
            $container->addCompilerPass(new SymfonyCmfSimpleCmsCompilerPass());
        }

        if (isset($bundles['CmfRoutingBundle'])) {
            $container->addCompilerPass(new SymfonyCmfRoutingCompilerPass());
        }

        if (isset($bundles['SonataNewsBundle'])) {
            $container->addCompilerPass(new SonataNewsCompilerPass());
        }
    }

    private function _loadConfiguration(ContainerBuilder $container)
    {
        if (class_exists('Doctrine\Bundle\PHPCRBundle\DependencyInjection\Compiler\DoctrinePhpcrMappingsPass')) {
            $container->addCompilerPass(
                DoctrinePhpcrMappingsPass::createYamlMappingDriver(
                    array(
                        /* realpath(__DIR__ . '/Resources/config/doctrine-model') => 'Symfony\Cmf\Bundle\BlockBundle\Model', */
                        realpath(__DIR__ . '/Resources/config/doctrine-phpcr') => 'Kdm\CmfBundle\Doctrine\Phpcr',
                    ),
                    array('cmf_block.persistence.phpcr.manager_name'),
                    'cmf_block.backend_type_phpcr',
                    array('KdmCmfBundle' => 'Kdm\CmfBundle\Doctrine\Phpcr')
                )
            );
        }
    }
}
