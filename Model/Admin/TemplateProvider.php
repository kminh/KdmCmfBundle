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
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class TemplateProvider implements TemplateProviderInterface
{
    protected $templates;

    public function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplate($name, $logicalName)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplates(array $templates)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplatesForClass($className)
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(sprintf('Invalid class to get templates for: "%s"', $className));
        }

        if (!isset($this->templates[$className])) {
            throw new \InvalidArgumentException(sprintf('You need to define templates for "%s" via configuration under "kdm_cmf.templates".', $className));
        }

        return $this->templates[$className];
    }
}
