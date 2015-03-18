<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\AsseticBundle\FilterManager;

use Assetic\Filter\FilterInterface;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class ContentExtension extends \Twig_Extension
{
    protected $kernel;

    protected $filterManager;

    protected $uglifyjs;

    public function __construct(KernelInterface $kernel, FilterManager $filterManager)
    {
        $this->kernel        = $kernel;
        $this->filterManager = $filterManager;
        $this->uglifyjs      = $filterManager->has('uglifyjs2') ? $filterManager->get('uglifyjs2') : null;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('uglifyjs', array($this, 'uglifyjs'), array('is_safe' => array('js')))
        );
    }

    public function uglifyjs($content)
    {
        // if not in prod environment or we don't have uglifyjs ready don't
        // process the content
        if ($this->kernel->getEnvironment() != 'prod' || is_null($this->uglifyjs)) {
            return $content;
        }

        $asset = new \Assetic\Asset\StringAsset(
            $content, array(
                $this->uglifyjs
            )
        );

        return $asset->dump();
    }

    public function getName()
    {
        return 'kdm_cmf_content';
    }
}
