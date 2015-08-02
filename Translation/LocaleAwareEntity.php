<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Joel Arberman <joel@chatnik.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Translation;

use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
trait LocaleAwareEntity
{
    protected $locale;

    /**
     * @see TranslatableInterface::getLocale()
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @see TranslatableInterface::setLocale()
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }
}
