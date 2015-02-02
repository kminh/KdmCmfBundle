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

use Symfony\Cmf\Bundle\BlockBundle\Admin\SimpleBlockAdmin as CmfSimpleBlockAdmin;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class SimpleBlockAdmin extends CmfSimpleBlockAdmin
{
    protected $translationDomain = 'kdm_cmf_admin';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general')
                ->add('subTitle', 'text', array(
                    'required' => false
                ))
                ->add('abstract', 'textarea', array(
                    'required' => false
                ))
                /* ->add('body', 'sonata_type_formatter', array()) */
                ->add('uri', 'text', array(
                    'required' => false
                ))
                ->add('anchorText', 'text', array(
                    'required' => false
                ))
                ->reorder(array(
                    'parentDocument',
                    'name',
                    'title',
                    'subTitle',
                    'abstract',
                    'body'
                ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
    }
}
