<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Sonata\BlockBundle\Model\BlockInterface;

class FormBlockService extends BaseBlockService implements BlockServiceInterface
{
    protected $template = 'KdmCmfBundle:Block:block_form.html.twig';

    protected $formFactory;

    public function __construct($name, EngineInterface $templating, FormFactoryInterface $formFactory, $template = null)
    {
        if ($template) {
            $this->template = $template;
        }

        $this->formFactory = $formFactory;

        parent::__construct($name, $templating);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {
        throw new \RuntimeException('Not used at the moment, editing using a frontend or backend UI could be changed here');
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        throw new \RuntimeException('Not used at the moment, validation for editing using a frontend or backend UI could be changed here');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!$response) {
            $response = new Response();
        }

        $block = $blockContext->getBlock();

        if (!$block->getEnabled()) {
            return $response;
        }

        try {
            $form = $this->formFactory->createNamed('', $blockContext->getSetting('form_type'));
        } catch (\Exception $e) {
            return $response;
        }

        $response = $this->renderResponse($blockContext->getTemplate(), array(
            'form'     => $form->createView(),
            'block'    => $block,
            'settings' => $blockContext->getSettings()
        ), $response);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'form_title' => '',
            'form_type'  => '',
            'form_class' => '',
            'template'   => $this->template
        ));
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Form Block';
    }
}
