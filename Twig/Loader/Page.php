<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Twig\Loader;

use Symfony\Bridge\Doctrine\ManagerRegistry;

use Kdm\CmfBundle\Doctrine\Phpcr\Page as PageDocument;

/**
 * Allow using CMF pages as twig templates
 *
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class Page implements \Twig_LoaderInterface, \Twig_ExistsLoaderInterface
{
    protected $repository;

    protected $basePath = '/cms/content/pages';

    public function __construct(ManagerRegistry $mr)
    {
        $this->repository = $mr->getManager()->getRepository(PageDocument::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getSource($name)
    {
        $name = $this->parseName($name);

        $page = $this->repository->find($this->basePath . '/' . $name);
        if (is_null($page)) {
            return '';
        }

        // need to convert escaped chars back just in case
        return html_entity_decode($page->getBody(), ENT_QUOTES);
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheKey($name)
    {
        return $name;
    }

    /**
     * {@inheritDoc}
     */
    public function exists($name)
    {
        $name = $this->parseName($name);

        if (!$name) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isFresh($name, $time)
    {
        $name = $this->parseName($name);

        $page = $this->repository->find($this->basePath . '/' . $name);
        if (is_null($page)) {
            return true;
        }

        return $page->getUpdatedTime() <= $time;
    }

    protected function parseName($name)
    {
        $name = (string) $name;

        if (!preg_match('/^KdmPage:/', $name)) {
            return false;
        }

        return preg_replace('/^KdmPage:/', '', $name, 1);
    }
}
