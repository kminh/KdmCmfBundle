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

class SonataNewsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // use different templates for editing news without having to redefine
        // the admin service
        $definition = $container->getDefinition('sonata.news.admin.post');
        $definition->addMethodCall('setTemplate', array('edit', 'KdmCmfBundle:PostAdmin:edit.html.twig'));
    }
}
