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

namespace PhpInteractor\Tests\Utility\TokenParser;

use PhpInteractor\Utility\TokenParser\AbstractTokenParser;

class AbstractTokenParserTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_NAME = 'PhpInteractor\Utility\TokenParser\AbstractTokenParser';

    /** @var AbstractTokenParser */
    private $parser;

    /** @test */
    public function isAbstractToken()
    {
        $method = $this->getReflectedMethodToTest('isAbstractToken');
        $this->assertTrue($method->invoke($this->parser, T_ABSTRACT));
        $this->assertFalse($method->invoke($this->parser, T_CLASS));
    }

    /** @test */
    public function isClassToken()
    {
        $method = $this->getReflectedMethodToTest('isClassToken');
        $this->assertTrue($method->invoke($this->parser, T_CLASS));
        $this->assertFalse($method->invoke($this->parser, T_ABSTRACT));
    }

    /** @test */
    public function isClassType()
    {
        $method = $this->getReflectedMethodToTest('isClassType');
        $this->assertTrue($method->invoke($this->parser, T_ABSTRACT));
        $this->assertTrue($method->invoke($this->parser, T_CLASS));
        $this->assertTrue($method->invoke($this->parser, T_INTERFACE));
        $this->assertFalse($method->invoke($this->parser, T_STRING));
    }

    /** @test */
    public function isInterfaceToken()
    {
        $method = $this->getReflectedMethodToTest('isInterfaceToken');
        $this->assertTrue($method->invoke($this->parser, T_INTERFACE));
        $this->assertFalse($method->invoke($this->parser, T_ABSTRACT));
    }

    /** @test */
    public function isNamespaceSeparatorToken()
    {
        $method = $this->getReflectedMethodToTest('isNamespaceSeparatorToken');
        $this->assertTrue($method->invoke($this->parser, T_NS_SEPARATOR));
        $this->assertFalse($method->invoke($this->parser, T_ABSTRACT));
    }

    /** @test */
    public function isNamespaceToken()
    {
        $method = $this->getReflectedMethodToTest('isNamespaceToken');
        $this->assertTrue($method->invoke($this->parser, T_NAMESPACE));
        $this->assertFalse($method->invoke($this->parser, T_ABSTRACT));
    }

    /** @test */
    public function isStringToken()
    {
        $method = $this->getReflectedMethodToTest('isStringToken');
        $this->assertTrue($method->invoke($this->parser, T_STRING));
        $this->assertFalse($method->invoke($this->parser, T_ABSTRACT));
    }

    /** {@inheritDoc} */
    protected function  setUp()
    {
        parent::setUp();
        $this->parser = $this->getMockForAbstractClass(self::CLASS_NAME);
    }

    private function getReflectedMethodToTest($methodName)
    {
        $reflection = new \ReflectionClass($this->parser);
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }
}
