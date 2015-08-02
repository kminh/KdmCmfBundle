<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

use Kdm\CmfBundle\Translation\TranslatableNameInterface;
use Kdm\CmfBundle\Translation\Phpcr\I18nRouteCreator;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class TranslatableNameSubscriber implements EventSubscriber
{
    protected $routeCreator;

    public function __construct(I18nRouteCreator $routeCreator)
    {
        $this->routeCreator = $routeCreator;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist'
        ];
    }

    /**
     * Before persisting a translatable route entity, we check if there's a
     * locale node path at the route root, and create it if there's none. We
     * then create/update the route document at that route root
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $document = $args->getObject();

        if ($document instanceof TranslatableNameInterface) {
            // no i18n name set, nothing to do
            if (empty($document->getI18nName())) {
                return;
            }

            $this->routeCreator->createI18nRoute($document);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        // no changes made to the i18n name, nothing to do
        if (!$args->hasChangedField('i18nName')) {
            return;
        }

        $oldI18nName = $args->getOldValue('i18nName');
        $i18nName    = $args->getNewValue('i18nName');

        // update the route if found, or create it on the fly
        if (!$route = $dm->find(null, $localeNodePath . '/' . $oldI18nName)) {
            $route = $this->createI18nRoute($document, $dm);
        }
    }
}
