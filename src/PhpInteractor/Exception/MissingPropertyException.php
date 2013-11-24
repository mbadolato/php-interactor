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

namespace PhpInteractor\Exception;

class MissingPropertyException extends \Exception
{
    public function __construct($propertyName, $className, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf("No property %s exists in class: %s", $propertyName, $className);
        }

        parent::__construct($message, $code, $previous);
    }
}
