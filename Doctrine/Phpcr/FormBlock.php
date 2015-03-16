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

use Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr\AbstractBlock;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
class FormBlock extends AbstractBlock
{
    public function getType()
    {
        return 'kdm.cmf.block.form';
    }
}
