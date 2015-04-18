<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Temlating;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine;

use Symfony\Bundle\TwigBundle\TwigEngine;

use Kdm\CmfBundle\Temlating\FilterDelegatingEngineResponseEvent;
use Kdm\CmfBundle\Temlating\FilterDelegatingEngineRenderEvent;
use Kdm\CmfBundle\Temlating\DelegatingEngineEvents;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class EventableDelegatingEngine extends DelegatingEngine
{
    /**
     * {@inheritdoc}
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        $event = new FilterDelegatingEngineResponseEvent($view, $parameters, $response, $this->getRequest());
        $this->getEventDispatcher()->dispatch(DelegatingEngineEvents::PRE_RENDER_RESPONSE, $event);

        return parent::renderResponse($event->getView(), $event->getParameters(), $event->getResponse());
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = array())
    {
        $event = new FilterDelegatingEngineRenderEvent($name, $parameters, $this->getRequest());
        $this->getEventDispatcher()->dispatch(DelegatingEngineEvents::PRE_RENDER, $event);

        return parent::render($event->getView(), $event->getParameters());
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine($name)
    {
        $this->resolveEngines();

        // @todo make this more portable
        foreach ($this->engines as $engine) {
            if (($engine instanceof TwigEngine && strpos($name, 'Kdm') !== false)
                || $engine->supports($name)
            ) {
                return $engine;
            }
        }

        throw new \RuntimeException(sprintf('No engine is able to work with the template "%s".', $name));
    }

    /**
     * @return EventDispatcherInterface
     */
    protected function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        try {
            return $this->container->get('request');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Resolved engine ids to their real engine instances from the container.
     */
    private function resolveEngines()
    {
        foreach ($this->engines as $i => $engine) {
            if (is_string($engine)) {
                $this->engines[$i] = $this->container->get($engine);
            }
        }
    }
}
