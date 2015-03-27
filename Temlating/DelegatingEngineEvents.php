<?php

/**
 * This file is part of the Kdm package.
 *
 * (c) 2015 Khang Minh <kminh@kdmlabs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kdm\CmfBundle\Temlating;

/**
 * @author Khang Minh <kminh@kdmlabs.com>
 */
final class DelegatingEngineEvents
{
    const PRE_RENDER = 'delegating_engine.pre_render';

    const PRE_RENDER_RESPONSE = 'delegating_engine.pre_render_response';
}
