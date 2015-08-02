<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Translation;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
interface TranslatableNameInterface
{
    /**
     * Set a name that is used for translation
     *
     * @param string $i18nName
     */
    public function setI18nName($i18nName);

    /**
     * Get the i18n name
     *
     * @return string
     */
    public function getI18nName();
}
