<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminInterface;

use Symfony\Cmf\Bundle\CoreBundle\Admin\Extension\TranslatableExtension as BaseTranslatableExtension;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class TranslatableExtension extends BaseTranslatableExtension
{
    /**
     * When a document fallbacks to a locale, it will set its locale to that
     * fallback locale, and when we update translated fields of that document,
     * the data will be saved with the fallback locale.
     *
     * Not sure what's the best way to handle this, for now we reset the
     * document's locale to the request's locale, so when updating translated
     * fields, the data will be saved with the request's locale.
     *
     * {@inheritdoc}
     */
    public function alterObject(AdminInterface $admin, $object)
    {
        // do the same thing when we create new document
        $this->alterNewInstance($admin, $object);
    }
}
