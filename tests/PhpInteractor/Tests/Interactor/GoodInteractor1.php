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

namespace PhpInteractor\Tests\Interactor;

use PhpInteractor\InteractorInterface;

class GoodInteractor1 implements InteractorInterface
{
    /** {@inheritDoc} */
    public function execute()
    {
        // TODO: Implement execute() method.
    }

    /** {@inheritDoc} */
    public function getName()
    {
        return 'GoodInteractor1';
    }
}
