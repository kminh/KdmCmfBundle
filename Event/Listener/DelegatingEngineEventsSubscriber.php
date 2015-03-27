<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Event\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

use Symfony\Cmf\Bundle\SeoBundle\SeoPresentationInterface;

use Kdm\CmfBundle\Doctrine\Phpcr\Page;
use Kdm\CmfBundle\Temlating\FilterDelegatingEngineRenderEvent;
use Kdm\CmfBundle\Temlating\FilterDelegatingEngineResponseEvent;
use Kdm\CmfBundle\Temlating\DelegatingEngineEvents;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class DelegatingEngineEventsSubscriber implements EventSubscriberInterface
{
    protected $seoPresentation;

    public function __construct(SeoPresentationInterface $seoPresentation)
    {
        $this->seoPresentation = $seoPresentation;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            DelegatingEngineEvents::PRE_RENDER => array('onDelegatingEnginePreRender'),
            DelegatingEngineEvents::PRE_RENDER_RESPONSE => array('onDelegatingEnginePreRenderResponse')
        );
    }

    public function onDelegatingEnginePreRender(FilterDelegatingEngineRenderEvent $event)
    {
        $this->populateSeoData($event->getParameters());
    }

    public function onDelegatingEnginePreRenderResponse(FilterDelegatingEngineResponseEvent $event)
    {
        $this->populateSeoData($event->getParameters());
    }

    protected function populateSeoData(array $params)
    {
        if (!empty($params['page']) && $params['page'] instanceof Page) {
            $this->seoPresentation->updateSeoPage($params['page']);
        }
    }
}
