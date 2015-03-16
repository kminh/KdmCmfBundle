<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Model\Admin;

/**
 * A template provider is used to provide a list of template files to used for
 * a particular admin.
 *
 * @author Khang Minh <kminh@kdmlabs.com>
 */
interface TemplateProviderInterface
{
    /**
     * Set a template
     *
     * @param string $name the name that is displayed
     * @param string $logicalName the name used to locate template file
     */
    public function setTemplate($name, $logicalName);

    /**
     * Set an entire template list
     *
     * @param array $templates
     */
    public function setTemplates(array $templates);

    /**
     * @param string $className FQN of the class to get templates for
     * @return array should be in this format: [template's logical name =>
     *               friendly name]
     */
    public function getTemplatesForClass($className);
}
