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

    /**
     * Datetime when this page is created
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * Datetime when this page is updated
     *
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->setOption('add_trailing_slash', true);
    }

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

    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getUpdatedTime()
    {
        // old pages don't have updatedAt field
        if (is_null($this->updatedAt)) {
            return 0;
        }

        return $this->updatedAt->format('U');
    }

    public function onPrePersist()
    {
        $this
            ->setCreatedAt()
            ->setUpdatedAt();
    }

    public function onPreUpdate()
    {
        $this->setUpdatedAt();
    }
}
