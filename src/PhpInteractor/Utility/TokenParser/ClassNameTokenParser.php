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

namespace PhpInteractor\Utility\TokenParser;

class ClassNameTokenParser extends AbstractTokenParser
{
    /** {@inheritDoc} */
    public static function parse(array $tokens)
    {
        $located    = false;
        $className  = null;

        foreach ($tokens as $token) {
            if ($className) {
                break;
            } elseif (self::isClassStart($token)) {
                $located = true;
            } else {
                $className .= self::parseClassName($token, $located);
            }
        }

        return $className;
    }

    private static function isClassNameSection($token, $tokenHasBeenLocation)
    {
        return $tokenHasBeenLocation && is_array($token) && self::isStringToken($token[0]);
    }

    private static function isClassStart($token)
    {
        return is_array($token) && self::isClassType($token[0]);
    }

    private static function parseClassName($token, $tokenHasBeenLocated)
    {
        return self::isClassNameSection($token, $tokenHasBeenLocated) ? $token[1] : null;
    }
}
