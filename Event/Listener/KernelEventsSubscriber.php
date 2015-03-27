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

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class KernelEventsSubscriber implements EventSubscriberInterface
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
            // must be called before FOSRestBundle's view listener
            // @see vendor/friendsofsymfony/rest-bundle/FOS/RestBundle/Resources/config/view_response_listener.xml
            KernelEvents::VIEW => array('onKernelView', 101)
            /* KernelEvents::RESPONSE => 'onKernelReponse', */
        );
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!empty($result['page']) && $result['page'] instanceof Page) {
            $this->seoPresentation->updateSeoPage($result['page']);
        }
    }

    public function onKernelReponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $parameters = $request->attributes->get('_response');

        if (!empty($parameters['page'])) {
        }
    }
}
