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

class NamespaceTokenParser extends AbstractTokenParser
{
    /** {@inheritDoc} */
    public static function parse(array $tokens)
    {
        $located    = false;
        $namespace  = null;

        foreach ($tokens as $token) {
            if (self::isNamespaceStart($token)) {
                $located = true;
            } elseif (self::isNamespaceEnd($token, $located)) {
                break;
            } else {
                $namespace .= self::parseNamespaceSectionName($token, $located);
            }
        }

        return $namespace;
    }

    private static function isNamespaceEnd($token, $tokenHasBeenLocated)
    {
        return $tokenHasBeenLocated && is_string($token) && (';' == $token);
    }

    private static function isNamespaceSection($token, $tokenHasBeenLocated)
    {
        return $tokenHasBeenLocated && (self::isStringToken($token[0]) || self::isNamespaceSeparatorToken($token[0]));
    }

    private static function isNamespaceStart($token)
    {
        return is_array($token) && self::isNamespaceToken($token[0]);
    }

    private static function parseNamespaceSectionName($token, $tokenHasBeenLocated)
    {
        return self::isNamespaceSection($token, $tokenHasBeenLocated) ? $token[1] : null;
    }
}
