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

class DependencyCoordinatorTest extends \PHPUnit_Framework_TestCase
{
    const DEFINED_INTERACTOR        = 'TestInteractorName';
    const NON_DEFINED_INTERACTOR    = 'InteractorNotSpecificallyDefinedSoOnlyGlobalDependencies';

    /** @var DependencyCoordinator */
    private $manager;

    /** @test */
    public function registerGlobalDependency()
    {
        $this->manager->registerGlobalDependency('standard', new \stdClass());
        $dependencies = $this->manager->getDependencyMap(self::NON_DEFINED_INTERACTOR);
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('standard'));
        $this->assertInstanceOf('stdClass', $dependencies->get('standard'));
    }

    /** @test */
    public function registerInteractorDependency()
    {
        $this->manager->registerInteractorDependency('standard', new \stdClass(), self::DEFINED_INTERACTOR);
        $dependencies = $this->manager->getDependencyMap(self::DEFINED_INTERACTOR);
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('standard'));
        $this->assertInstanceOf('stdClass', $dependencies->get('standard'));
    }

    /** @test */
    public function registerMultipleInteractorDependencies()
    {
        $this->manager->registerInteractorDependency('standard', new \stdClass(), self::DEFINED_INTERACTOR);
        $this->manager->registerInteractorDependency('additional', new \stdClass(), self::DEFINED_INTERACTOR);
        $dependencies = $this->manager->getDependencyMap(self::DEFINED_INTERACTOR);
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('standard'));
        $this->assertTrue($dependencies->has('additional'));
        $this->assertInstanceOf('stdClass', $dependencies->get('additional'));
    }

    /** @test */
    public function registerGlobalAndInteractorDependencies()
    {
        $this->manager->registerGlobalDependency('global', new \stdClass());
        $this->manager->registerInteractorDependency('standard', new \stdClass(), self::DEFINED_INTERACTOR);

        $dependencies = $this->manager->getDependencyMap(self::NON_DEFINED_INTERACTOR);
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('global'));
        $this->assertFalse($dependencies->has('standard'));

        $dependencies = $this->manager->getDependencyMap(self::DEFINED_INTERACTOR);
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('global'));
        $this->assertTrue($dependencies->has('standard'));
        $this->assertInstanceOf('stdClass', $dependencies->get('global'));
        $this->assertInstanceOf('stdClass', $dependencies->get('standard'));
    }

    /** @test */
    public function registerGlobalAndMultipleInteractorWithDependencies()
    {
        $this->manager->registerGlobalDependency('global', new \stdClass());
        $this->manager->registerInteractorDependency('standard', new \stdClass(), self::DEFINED_INTERACTOR);
        $this->manager->registerInteractorDependency('additional', new \stdClass(), 'TestInteractorName2');

        $dependencies = $this->manager->getDependencyMap(self::NON_DEFINED_INTERACTOR);
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('global'));
        $this->assertFalse($dependencies->has('standard'));

        $dependencies = $this->manager->getDependencyMap(self::DEFINED_INTERACTOR);
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('global'));
        $this->assertTrue($dependencies->has('standard'));
        $this->assertFalse($dependencies->has('additional'));
        $this->assertInstanceOf('stdClass', $dependencies->get('global'));
        $this->assertInstanceOf('stdClass', $dependencies->get('standard'));

        $dependencies = $this->manager->getDependencyMap('TestInteractorName2');
        $this->assertEquals(2, $dependencies->count());
        $this->assertTrue($dependencies->has('global'));
        $this->assertTrue($dependencies->has('additional'));
        $this->assertFalse($dependencies->has('standard'));
        $this->assertInstanceOf('stdClass', $dependencies->get('global'));
        $this->assertInstanceOf('stdClass', $dependencies->get('additional'));
    }

    /** @test */
    public function registerInteractorDependencyAlreadyDefinedGlobally()
    {
        $this->manager->registerGlobalDependency('standard', new \stdClass());
        $this->manager->registerInteractorDependency('standard', new \stdClass(), self::DEFINED_INTERACTOR);
        $dependencies = $this->manager->getDependencyMap('standard');
        $this->assertEquals(1, $dependencies->count());
        $this->assertTrue($dependencies->has('standard'));
    }

    protected function setUp()
    {
        $this->manager = new DependencyCoordinator();
    }
}
