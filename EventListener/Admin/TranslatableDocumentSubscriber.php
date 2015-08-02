<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\EventListener\Admin;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;

use Sonata\AdminBundle\Event\PersistenceEvent;

use Kdm\CmfBundle\Doctrine\Phpcr\Route;
use Kdm\CmfBundle\Translation\TranslatableNameInterface;
use Kdm\CmfBundle\Translation\Phpcr\I18nRouteCreator;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class TranslatableDocumentSubscriber implements EventSubscriberInterface
{
    protected $routeCreator;

    /**
     * @var DocumentManager
     */
    protected $dm;

    public function __construct(
        I18nRouteCreator $routeCreator,
        ManagerRegistry $registry)
    {
        $this->routeCreator = $routeCreator;
        $this->dm           = $registry->getManager();
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'sonata.admin.event.persistence.pre_update' => ['onPersistencePreUpdate']
        ];
    }

    public function onPersistencePreUpdate(PersistenceEvent $event)
    {
        $object = $event->getObject();

        if (!$object instanceof TranslatableNameInterface) {
            return;
        }

        $locale = $this->routeCreator->getCurrentLocale($object);

        // if there's an existing route document for the current locale
        if ($route = $object->getRoutes()->filter(function(Route $route) use ($locale) {
            // the locale appears at the index 0 of the route's path
            if (strpos($route->getPath(), '/' . $locale . '/') === 0) {
                return true;
            }
        })->current()) {
            // remove the route if the i18n name is empty
            if (empty($object->getI18nName())) {
                $this->dm->remove($route);

                // done
                return;
            }

            // need to update the route
            $route->setName($object->getI18nName());
            $route->setOption('add_trailing_slash', $object->getOption('add_trailing_slash') ?: false);

            // done
            return;
        }

        // need to create a new route document
        $this->routeCreator->createI18nRoute($object);
    }
}
