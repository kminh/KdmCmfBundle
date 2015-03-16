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
class FormTypeProvider implements FormTypeProviderInterface
{
    protected $formTypes;

    public function __construct(array $formTypes)
    {
        $this->formTypes = $formTypes;
    }

    /**
     * Set a form type
     *
     * @param string $name the name that is displayed
     * @param string $type the actual form type
     */
    public function setFormType($name, $type)
    {
    }

    /**
     * Set an entire form type list
     *
     * @param array $formTypes
     */
    public function setFormTypes(array $formTypes)
    {
    }

    /**
     * @return array should be in this format: [form_type => friendly name]
     */
    public function getFormTypes()
    {
        return $this->formTypes;
    }
}
