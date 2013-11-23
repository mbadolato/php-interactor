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

namespace PhpInteractor\Utility;

use PhpInteractor\Exception\ClassDoesNotExistException;
use PhpInteractor\Exception\NonInteractorException;

class Assert
{
    public static function classExists($className)
    {
        if (! class_exists($className)) {
            throw new ClassDoesNotExistException($className);
        }
    }

    public static function isInteractor($className)
    {
        $reflection = new \ReflectionClass($className);

        if (! $reflection->implementsInterface('PhpInteractor\InteractorInterface')) {
            throw new NonInteractorException($className);
        }
    }
}
