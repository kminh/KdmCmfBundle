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
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class FilterDelegatingEngineRenderEvent extends Event
{
    protected $view;
    protected $parameters = [];
    protected $request;

    /**
     * @param $view
     * @param array $parameters
     * @param Response $response
     * @param Request $request
     */
    public function __construct(&$view, array &$parameters = array(), Request $request = null)
    {
        $this->view       = $view;
        $this->parameters = $parameters;
        $this->request    = $request;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
