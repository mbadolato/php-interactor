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

use PhpInteractor\DependencyCoordinator;
use PhpInteractor\Dispatcher;
use PhpInteractor\InteractorMap;
use PhpInteractor\Tests\Request\GoodInteractor1Request;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    const INTERACTOR_MAP_CLASS = 'PhpInteractor\InteractorMap';

    /** @var Dispatcher */
    private $manager;

    /** @test */
    public function getClassName()
    {
        $this->assertEquals('PhpInteractor\Tests\Interactor\GoodInteractor1', $this->manager->getClassName('GoodInteractor1'));
    }

    /** @test */
    public function isInteractorRegistered()
    {
        $this->assertTrue($this->manager->isInteractorRegistered('GoodInteractor1'));
        $this->assertFalse($this->manager->isInteractorRegistered('Test'));
    }

    /** @test */
    public function oneRegisteredGlobalDependency()
    {
        $dependencies = $this->manager->getDependencies('GoodInteractor1');
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('global_dependency_1'));
        $this->assertFalse($dependencies->has('test_dependency'));
    }

    /** @test */
    public function twoRegisteredGlobalDependencies()
    {
        $this->manager->registerDependency('global_dependency_2', 'GlobalDependency2');
        $dependencies = $this->manager->getDependencies('GoodInteractor1');
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('global_dependency_1'));
        $this->assertTrue($dependencies->has('global_dependency_2'));
        $this->assertFalse($dependencies->has('test_dependency'));
    }

    /** @test */
    public function oneRegisteredInteractorDependency()
    {
        $this->manager->registerDependency('interactor_dependency_1', 'InteractorDependency1', 'GoodInteractor1');
        $dependencies = $this->manager->getDependencies('GoodInteractor1');
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('global_dependency_1'));
        $this->assertTrue($dependencies->has('interactor_dependency_1'));
        $this->assertFalse($dependencies->has('test_dependency'));
    }

    /** @test */
    public function twoRegisteredInteractorDependencies()
    {
        $this->manager->registerDependency('interactor_dependency_1', 'InteractorDependency1', 'GoodInteractor1');
        $this->manager->registerDependency('interactor_dependency_2', 'InteractorDependency2', 'GoodInteractor1');
        $dependencies = $this->manager->getDependencies('GoodInteractor1');
        $this->assertEquals(3, $dependencies->count());
        $this->assertTrue($dependencies->has('global_dependency_1'));
        $this->assertTrue($dependencies->has('interactor_dependency_1'));
        $this->assertTrue($dependencies->has('interactor_dependency_2'));
        $this->assertFalse($dependencies->has('test_dependency'));
    }

    /** @test */
    public function oneRegisteredInteractor()
    {
        $this->assertEquals(1, $this->manager->registeredCount());
    }

    /** @test */
    public function twoRegisteredInteractors()
    {
        $this->manager->registerInteractor('GoodInteractor2', 'PhpInteractor\Tests\Interactor\GoodInteractor2');
        $this->assertEquals(2, $this->manager->registeredCount());
    }

    /** @test */
    public function execute()
    {
        $this->manager->execute(new GoodInteractor1Request(['userId' => 123, 'emailAddress' => 'new@example.com']));
    }

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\MissingPropertyException
     */
    public function executeWithBadProperty()
    {
        $this->manager->execute(new GoodInteractor1Request(['userId' => 123, 'emailAddress' => 'new@example.com', 'bad_property' => 'Error']));
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->manager = new Dispatcher(new InteractorMap(), new DependencyCoordinator());
        $this->registerInteractors();
        $this->registerDependencies();
    }

    private function registerDependencies()
    {
        $this->manager->registerDependency('global_dependency_1', 'GlobalDependency1');
    }

    private function registerInteractors()
    {
        $this->manager->registerInteractor('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');
    }
}
