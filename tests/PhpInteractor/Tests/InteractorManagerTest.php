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

use PhpInteractor\InteractorManager;

class InteractorManagerTest extends \PHPUnit_Framework_TestCase
{
    const INTERACTOR_MAP_CLASS = 'PhpInteractor\InteractorMap';

    /** @var InteractorManager */
    private $manager;

    /** @test */
    public function getClassName()
    {
        $this->manager->register('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');
        $this->assertEquals('PhpInteractor\Tests\Interactor\GoodInteractor1', $this->manager->getClassName('GoodInteractor1'));
    }

    /** @test */
    public function isRegistered()
    {
        $this->manager->register('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');
        $this->assertTrue($this->manager->isRegistered('GoodInteractor1'));
        $this->assertFalse($this->manager->isRegistered('Test'));
    }

    /** @test */
    public function registeredOne()
    {
        $this->manager->register('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');
        $this->assertEquals(1, $this->manager->registeredCount());
    }

    /** @test */
    public function registeredTwo()
    {
        $this->manager->register('GoodInteractor1', 'PhpInteractor\Tests\Interactor\GoodInteractor1');
        $this->manager->register('GoodInteractor2', 'PhpInteractor\Tests\Interactor\GoodInteractor2');
        $this->assertEquals(2, $this->manager->registeredCount());
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        $this->manager = new InteractorManager();
    }
}
