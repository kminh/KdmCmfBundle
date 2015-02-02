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

use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\SimpleBlock as CmfSimpleBlock;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class SimpleBlock extends CmfSimpleBlock
{
    protected $subTitle;

    protected $abstract;

    protected $uri;

    protected $route;

    protected $contentDocument;

    protected $anchorText;

    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
    }

    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function setAnchorText($anchorText)
    {
        $this->anchorText = $anchorText;
    }

    public function getSubTitle()
    {
        return $this->subTitle;
    }

    public function getAbstract()
    {
        return $this->abstract;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAnchorText()
    {
        return $this->anchorText;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'uri',
            new Assert\Url()
        );
    }
}
