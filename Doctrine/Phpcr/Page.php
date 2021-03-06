<?php

/**
 * This file is part of the KdmCmfBundle package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Doctrine\Phpcr;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Cmf\Component\Routing\RouteObjectInterface;

use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareTrait;
use Symfony\Cmf\Bundle\SeoBundle\SeoAwareInterface;
use Symfony\Cmf\Bundle\SeoBundle\Extractor;

use Symfony\Cmf\Bundle\SimpleCmsBundle\Doctrine\Phpcr\Page as BasePage;

use Kdm\CmfBundle\Translation\TranslatableNameInterface;
use Kdm\CmfBundle\Translation\TranslatableNameTrait;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class Page extends BasePage implements
    SeoAwareInterface,
    Extractor\DescriptionReadInterface,
    Extractor\TitleReadInterface,
    /* Extractor\OriginalRouteReadInterface, */
    Extractor\ExtrasReadInterface,
    TranslatableNameInterface
{
    /* protected $idPrefix = '/cms/content/pages'; */

    use SeoAwareTrait;

    use TranslatableNameTrait;

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

    /**
     * @var ArrayCollection of RouteObjectInterface
     */
    protected $routes;

    public function __construct()
    {
        // use this to avoid an error in phpcr proxy class
        // @see https://github.com/symfony-cmf/SeoBundle/issues/201
        $this->seoMetadata = new SeoMetadata();

        $this->routes = new ArrayCollection();

        // add trailing slash by default
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

    /**
     * {@inheritDoc}
     */
    public function getRoutes()
    {
        /* $routes = clone $this->routes; */
        /* $routes->add($this); */

        return $this->routes;
    }

    public function getSeoTitle()
    {
        return $this->getSeoMetadata()->getTitle() ?: $this->getTitle();
    }

    public function getSeoDescription()
    {
        $description = $this->getSeoMetadata()->getMetaDescription() ?: substr(strip_tags($this->getBody()), 0, 150);

        return trim(preg_replace('/\s+/', ' ', strip_tags($description)));
    }

    public function getSeoOriginalRoute()
    {
        return $this->id;
    }

    public function getSeoExtras()
    {
        return array(
            'property' => array(
                'og:title'       => $this->getSeoTitle(),
                'og:description' => $this->getSeoDescription(),
            )
        );
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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
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

    public function __toString()
    {
        return $this->getName();
    }
}
