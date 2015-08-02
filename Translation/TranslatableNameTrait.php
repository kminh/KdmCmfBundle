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
trait TranslatableNameTrait
{
    /**
     * Translatable name
     *
     * @var string
     */
    protected $i18nName;

    /**
     * {@see TranslatableNameInterface}
     */
    public function setI18nName($i18nName)
    {
        $this->i18nName = $i18nName;
    }

    /**
     * {@see TranslatableNameInterface}
     */
    public function getI18nName()
    {
        return $this->i18nName;
    }
}
