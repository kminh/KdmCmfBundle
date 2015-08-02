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

use Symfony\Cmf\Bundle\RoutingBundle\Admin\RouteAdmin as BaseRouteAdmin;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class RouteAdmin extends BaseRouteAdmin
{
    protected $translationDomain = 'KdmCmfBundle';

    public function setRouteRoot($routeRoot)
    {
        // make limitation on base path work
        parent::setRootPath($routeRoot);
        // Watch this issue
        // https://github.com/sonata-project/SonataDoctrinePhpcrAdminBundle/issues/148
        $this->routeRoot = $routeRoot;
    }

    /**
     * {@inheritdoc}
     */
    /* protected function configureRoutes(RouteCollection $collection) */
    /* { */
    /*     // Custom admin routes, can use: add(), remove(), clearExcept(), getRouterIdParameter() */
    /* } */

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->remove('variablePattern')
            ->remove('defaults')
            ->with('form.group_general', array(
                'class' => 'col-md-8'
            ))
            ->end()
            ->with('form.group_advanced', array(
                'translation_domain' => 'CmfRoutingBundle',
                'class' => 'col-md-4'
            ))
                ->add(
                    'options', 'sonata_type_immutable_array', array(
                        'keys'  => $this->configureFieldsForOptions($this->getSubject()->getOptions()),
                        'label' => false
                    )
                )
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFieldsForDefaults($dynamicOptions)
    {
        $defaults = parent::configureFieldsForDefaults($dynamicOptions);

        if (isset($defaults['_locale'])) {
            unset($defaults['_locale']);
        }

        return $defaults;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFieldsForOptions(array $dynamicOptions)
    {
        $options = parent::configureFieldsForOptions($dynamicOptions);

        $removeOptions = [
            'add_locale_pattern',
            'add_format_pattern',
            'compiler_class'
        ];

        foreach ($removeOptions as $name) {
            if (isset($options[$name])) {
                unset($options[$name]);
            }
        }

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    /* protected function configureDatagridFilters(DatagridMapper $datagridMapper) */
    /* { */
    /*     // Fields to be shown on filter forms */
    /* } */

    /**
     * {@inheritdoc}
     */
    /* protected function configureListFields(ListMapper $listMapper) */
    /* { */
    /*     // Fields to be shown when listing items */
    /* } */

    /* protected function configureShowFields(ShowMapper $showMapper) */
    /* { */
    /*     // Fields to be shown when viewing an item */
    /* } */
}
