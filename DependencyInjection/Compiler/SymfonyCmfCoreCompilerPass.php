<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Kdm\CmfBundle\Admin\Extension\TranslatableExtension;

class SymfonyCmfCoreCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // use KdmCmfBundle's translatable admin extension class
        $container->setParameter('cmf_core.admin_extension.translatable.class', TranslatableExtension::class);
    }
}
