<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Doctrine\Phpcr;

use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page as BasePage;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class Page extends BasePage
{
    /* protected $idPrefix = '/cms/content/pages'; */

    /**
     * Format of the page body
     *
     * @var string
     */
    protected $format = 'richhtml';

    /**
     * Raw content of the body, before formatted. Same as 'body'
     *
     * @var string
     */
    protected $bodyRaw;

    /**
     * Contents of body, after formatted, used to present to users.
     *
     * @var string
     */
    protected $bodyFormatted;

    /**
     * Whether this page should be used for internal purpose only
     *
     * @var bool
     */
    protected $internal = false;

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function setBodyRaw($bodyRaw)
    {
        $this->bodyRaw = $bodyRaw;
    }

    public function setBodyFormatted($bodyFormatted)
    {
        $this->bodyFormatted = $bodyFormatted;
    }

    public function setInternal($internal)
    {
        $this->internal = (bool) $internal;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getBodyRaw()
    {
        return $this->bodyRaw;
    }

    public function getBodyFormatted()
    {
        return $this->bodyFormatted;
    }

    public function isInternal()
    {
        return (bool) $this->internal;
    }
}
