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

namespace PhpInteractor\Tests\Utility;

use PhpInteractor\Utility\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function classExists()
    {
        Assert::classExists('\StdClass');
    }

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\ClassDoesNotExistException
     */
    public function classDoesNotExistExist()
    {
        Assert::classExists('\Non\Existent\ClassName');
    }

    /** @test */
    public function isInteractor()
    {
        Assert::isInteractor('PhpInteractor\Tests\Interactor\GoodInteractor1');
    }

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\NonInteractorException
     */
    public function isNotInteractor()
    {
        Assert::isInteractor('PhpInteractor\Tests\Interactor\NoInterfaceImplementation');
    }
}
