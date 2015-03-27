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
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class FilterDelegatingEngineResponseEvent extends Event
{
    protected $view;
    protected $parameters = [];
    protected $response;
    protected $request;

    /**
     * @param $view
     * @param array $parameters
     * @param Response $response
     * @param Request $request
     */
    public function __construct(&$view, array &$parameters = array(), Response $response = null, Request $request = null)
    {
        $this->view       = $view;
        $this->parameters = $parameters;
        $this->response   = $response;
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
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
