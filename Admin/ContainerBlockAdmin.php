<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Symfony\Cmf\Bundle\BlockBundle\Admin\ContainerBlockAdmin as Admin;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class ContainerBlockAdmin extends Admin
{
    protected $translationDomain = 'CmfBlockBundle';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        // Custom admin routes, can use: add(), remove(), clearExcept(), getRouterIdParameter()
        parent::configureRoutes($collection);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // Fields to be shown on create/edit forms
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general')
                ->add('enabled', 'checkbox', array('required' => false))
            ->end()
            ->with('form.group_settings')
                ->add('settings', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('divisible_by', 'text', array(
                            'required'   => false,
                            'label'      => 'form.label_divisible_by'
                        )),
                        array('divisible_class', 'text', array('required' => false, 'label' => 'form.label_divisible_class')),
                        array('child_class', 'text', array('required' => false, 'label' => 'form.label_child_class'))
                    ),
                    'label' => false,
                    'translation_domain' => 'CmfBlockBundle'
                ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        // Fields to be shown on filter forms
        parent::configureDatagridFilters($datagridMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        // Fields to be shown when listing items
        parent::configureListFields($listMapper);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        // Fields to be shown when viewing an item
        parent::configureShowFields($showMapper);
    }
}
