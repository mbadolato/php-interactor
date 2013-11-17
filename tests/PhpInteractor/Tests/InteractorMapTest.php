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

namespace PhpInteractor\Tests;

use PhpInteractor\InteractorMap;

class InteractorMapTest extends \PHPUnit_Framework_TestCase
{
    const INTERACTOR_CLASS  = 'PhpInteractor\Tests\Interactor\GoodInteractor1';
    const INTERACTOR_NAME   = 'GoodInteractor1';

    /** @var InteractorMap */
    private $map;

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\InteractorAlreadyDefinedException
     */
    public function addDuplicateInteractorNameDifferentClassName()
    {
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->map->add(self::INTERACTOR_NAME, 'PhpInteractor\Tests\Interactor\GoodInteractor2');
    }

    /** @test */
    public function addDuplicateInteractorNameSameClassName()
    {
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->assertEquals(1, $this->map->count());
    }

    /**
     * @test
     * @expectedException        \Assert\InvalidArgumentException
     * @expectedExceptionMessage \PhpInteractor\InteractorMap::ERR_NO_CLASS
     */
    public function addInteractorWithInvalidClass()
    {
        $this->map->add('TestInteractorName', 'Some\Path\To\TestInteractorName');
    }

    /**
     * @test
     * @expectedException        \Assert\InvalidArgumentException
     * @expectedExceptionMessage \PhpInteractor\InteractorMap::ERR_NOT_IMPLEMENTED
     */
    public function addInteractorThatDoesNotImplementInteractorInterface()
    {
        $this->map->add('NoInterfaceImplementation', 'PhpInteractor\Tests\Interactor\NoInterfaceImplementation');
    }

    /** @test */
    public function counter()
    {
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->assertEquals(1, $this->map->count());
    }

    /** @test */
    public function getClassName()
    {
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->assertEquals(self::INTERACTOR_CLASS, $this->map->getInteractorClass(self::INTERACTOR_NAME));
    }

    /** @test */
    public function has()
    {
        $this->map->add(self::INTERACTOR_NAME, self::INTERACTOR_CLASS);
        $this->assertTrue($this->map->has(self::INTERACTOR_NAME));
    }

    /** @test */
    public function iterator()
    {
        $this->assertInstanceOf('\Iterator', $this->map->iterator());
        $this->assertEquals(0, count($this->map->iterator()));
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->map = new InteractorMap();
    }
}
