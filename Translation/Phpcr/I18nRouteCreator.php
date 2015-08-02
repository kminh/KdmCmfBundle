<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Translation\Phpcr;

use Symfony\Component\DependencyInjection\ContainerInterface;

use PHPCR\Util\NodeHelper;

use Doctrine\ODM\PHPCR\DocumentManager;

use Kdm\CmfBundle\Doctrine\Phpcr\Route;
use Kdm\CmfBundle\Doctrine\Phpcr\Page;
use Kdm\CmfBundle\Translation\TranslatableNameInterface;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class I18nRouteCreator
{
    protected $container;

    protected $routeRoot;

    public function __construct(ContainerInterface $container)
    {
        $this->routeRoot = $container->getParameter('cmf_routing.dynamic.persistence.phpcr.admin_basepath');
        $this->container = $container;

        if (empty($this->routeRoot)) {
            throw new \DomainException('A root for routes must be defined, e.g. "/cms/routes"');
        }
    }

    /**
     * Create a new route if not exist
     *
     * @param TranslatableNameInterface $document
     */
    public function createI18nRoute(TranslatableNameInterface $document)
    {
        /* @var $dm DocumentManager */
        $dm = $this->container->get('doctrine_phpcr')->getManager();

        $locale         = $this->getCurrentLocale($document);
        $localeNodePath = $this->routeRoot . '/' . $locale;

        if (!$localeNode = $dm->find(null, $localeNodePath)) {
            $session = $dm->getPhpcrSession();

            // we create the local node path if it's not there, note that
            // the incoming locale must have been filtered to avoid
            // creating unnecessary nodes
            $localeNode = NodeHelper::createPath($session, $localeNodePath);

            // make sure the locale node is persisted
            $session->save();

            // need to reload the locale node here
            $localeNode = $dm->find(null, $localeNodePath);
        }

        // no i18n name, nothing to do
        if (empty($document->getI18nName())) {
            return;
        }

        $route = new Route([
            'add_trailing_slash' => $document->getOption('add_trailing_slash') ?: false
        ]);

        $route->setParentDocument($localeNode);
        $route->setContent($document);
        $route->setName($document->getI18nName());

        $dm->persist($route);
    }

    public function getRouteRoot()
    {
        return $this->routeRoot;
    }

    public function getCurrentLocale(TranslatableNameInterface $document = null)
    {
        $request = $this->container->get('request_stack')->getMasterRequest();

        if (!$locale = $request->getLocale()) {
            throw new \DomainException('A locale for the current request must be defined, e.g. "en"');
        }

        // use locale from the document if found
        if (!is_null($document)) {
            $locale = $document->getLocale() ?: $locale;
        }

        return $locale;
    }
}
