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
        $this->manager->setInteractorMap($this->getInteractorMap());
        $this->assertEquals('PhpInteractor\Tests\Interactor\GoodInteractor1', $this->manager->getClassName('GoodInteractor1'));
    }

    /** @test */
    public function isInteractorRegistered()
    {
        $this->manager->setInteractorMap($this->getInteractorMap());
        $this->assertTrue($this->manager->isRegistered('GoodInteractor1'));
        $this->assertFalse($this->manager->isRegistered('Test'));
    }

    /** @test */
    public function registeredOne()
    {
        $this->manager->setInteractorMap($this->getInteractorMap());
        $this->assertEquals(1, $this->manager->registeredCount());
    }

    /** @test */
    public function registeredTwo()
    {
        $interactorMap =$this->getInteractorMap();
        $interactorMap->add('GoodInteractor2', 'PhpInteractor\Tests\Interactor\GoodInteractor2');
        $this->manager->setInteractorMap($interactorMap);
        $this->assertEquals(2, $this->manager->registeredCount());
    }

    /** @test */
    public function execute()
    {
        $this->manager->setInteractorMap($this->getInteractorMap());
        $this->manager->execute(new GoodInteractor1Request(['userId' => 123, 'emailAddress' => 'new@example.com']));
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->manager = new Dispatcher(new InteractorMap(), new DependencyCoordinator());
    }

    private function getInteractorMap()
    {
        $interactorMap = new InteractorMap();
        $interactorMap->add('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');

        return $interactorMap;
    }
}
