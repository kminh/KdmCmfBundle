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

use Kdm\CmfBundle\Doctrine\Phpcr\Page;
use Kdm\CmfBundle\Model\Admin\TemplateProviderInterface;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class PageAdmin extends BasePageAdmin
{
    protected $templateProvider;

    public function setTemplateProvider(TemplateProviderInterface $provider)
    {
        $this->templateProvider = $provider;
    }

    public function setRouteRoot($routeRoot)
    {
        // make limitation on base path work
        parent::setRootPath($routeRoot);
        // Watch this issue
        // https://github.com/sonata-project/SonataDoctrinePhpcrAdminBundle/issues/148
        $this->routeRoot = $routeRoot;
    }

    protected function configureFieldsForDefaults($dynamicDefaults)
    {
        $defaults = parent::configureFieldsForDefaults($dynamicDefaults);

        $defaults['_template'] = array('_template', 'choice', array(
            'required'           => false,
            'choices'            => $this->templateProvider->getTemplatesForClass(Page::class),
            'placeholder'        => 'form.placeholder_template',
            'translation_domain' => 'KdmCmfBundle'
        ));

        return $defaults;
    }

    protected function configureFieldsForOptions(array $dynamicOptions)
    {
        $options = parent::configureFieldsForOptions($dynamicOptions);

        $options['compiler_class'] = array('compiler_class', 'hidden', [ 'label' => false, 'required' => false ]);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);

        $formMapper
            ->with('form.group_general', [
                'class' => 'col-md-8'
            ])
                ->remove('body')
                ->add('body', 'sonata_formatter_type', [
                    'listener'             => true,
                    'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'format_field'         => 'format',
                    'source_field'         => 'body',
                    'source_field_options' => [
                        'attr' => [
                            'rows' => 20
                        ]
                    ],
                    'target_field'         => 'bodyFormatted',
                    'ckeditor_context'     => 'lvs'
                ])
            ->end()
            ->with('form.group_seo', [
                'class' => 'col-md-4'
            ])
            ->end()
            ->with('form.group_advanced', [
                'class' => 'col-md-4'
            ])
                ->add('internal', 'checkbox', [
                    'required' => false,
                    'help'     => 'form.help_internal'
                ], [
                    'translation_domain' => 'CmfSimpleCmsBundle'
                ])
                ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureDatagridFilters($datagridMapper);

        $datagridMapper
            ->add('internal');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);

        $listMapper
            ->remove('label')
            ->add('internal', 'boolean', array('editable' => 'yes'));
    }
}
