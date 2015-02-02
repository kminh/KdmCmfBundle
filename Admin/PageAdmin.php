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

use Symfony\Cmf\Bundle\SimpleCmsBundle\Admin\PageAdmin as BasePageAdmin;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class PageAdmin extends BasePageAdmin
{
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
    /* protected function configureFormFields(FormMapper $formMapper) */
    /* { */
    /*     parent::configureFormFields($formMapper); */
    /* } */

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
