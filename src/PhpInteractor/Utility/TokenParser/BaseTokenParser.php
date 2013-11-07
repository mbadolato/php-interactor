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

abstract class BaseTokenParser implements TokenParserInterface
{
    protected static function isAbstractToken($token)
    {
        return T_ABSTRACT == $token;
    }

    protected static function isClassToken($token)
    {
        return T_CLASS == $token;
    }

    protected static function isClassType($token)
    {
        return self::isClassToken($token) || self::isInterfaceToken($token) || self::isAbstractToken($token);
    }

    protected static function isInterfaceToken($token)
    {
        return T_INTERFACE == $token;
    }

    protected static function isNamespaceSeparatorToken($token)
    {
        return T_NS_SEPARATOR === $token;
    }

    protected static function isNamespaceToken($token)
    {
        return T_NAMESPACE === $token;
    }

    protected static function isStringToken($token)
    {
        return T_STRING == $token;
    }
}
