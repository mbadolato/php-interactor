<?php

/**
 * This file is part of the PhpInteractor package
 *
 * @package    PhpInteractor
 * @author     Mark Badolato <mbadolato@cybernox.com>
 * @copyright  Copyright (c) CyberNox Technologies. All rights reserved.
 * @license    http://www.opensource.org/licenses/MIT MIT License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpInteractor\Tests\Request;

use PhpInteractor\Helper\AbstractInteractorRequest;

class GoodInteractor1Request extends AbstractInteractorRequest
{
    /** @var string */
    public $userId;

    /** @var string */
    public $emailAddress;
}
