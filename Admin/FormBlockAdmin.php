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

use Symfony\Component\Finder\Finder;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Kdm\CmfBundle\Doctrine\Phpcr\FormBlock;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class FormBlockAdmin extends BaseBlockAdmin
{
    protected $translationDomain = 'KdmCmfBundle';

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text')
            ->add('name', 'text')
        ;
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
                ->add('parentDocument', 'doctrine_phpcr_odm_tree', array('root_node' => $this->getRootPath(), 'choice_list' => array(), 'select_root_node' => true))
                ->add('name', 'text')
                ->add('enabled', 'checkbox', array('required' => false))
            ->end()
            ->with('form.group_settings')
                ->add('title', 'text', [
                    'required' => false,
                    'label'    => 'form.label_form_title'
                ])
                ->add('settings', 'sonata_type_immutable_array', array(
                    'keys' => array(
                        array('form_type', 'choice', array(
                            'required'    => true,
                            'label'       => 'form.label_form_type',
                            'choices'     => $this->formTypeProvider->getFormTypes(),
                            'placeholder' => 'form.placeholder_form_type'
                        )),
                        array('form_class', 'text', array(
                            'required'    => false,
                            'label'       => 'form.label_form_class',
                            /* 'sonata_help' => 'form.help_form_class' */
                        )),
                        array('template', 'choice', array(
                            'required'    => false,
                            'label'       => 'form.label_template',
                            'choices'     => $this->templateProvider->getTemplatesForClass(FormBlock::class),
                            'placeholder' => 'form.placeholder_template'
                        ))
                    ),
                    'label' => false,
                    'translation_domain' => 'KdmCmfBundle'
                ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', 'doctrine_phpcr_nodename')
        ;
    }
}
