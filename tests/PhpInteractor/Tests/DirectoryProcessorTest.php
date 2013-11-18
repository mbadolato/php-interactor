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

use PhpInteractor\DirectoryProcessor;

class DirectoryProcessorTest extends \PHPUnit_Framework_TestCase
{
    const INTERACTOR_CLASS_1    = 'PhpInteractor\Tests\Interactor\GoodInteractor1';
    const INTERACTOR_CLASS_2    = 'PhpInteractor\Tests\Interactor\GoodInteractor2';
    const INTERACTOR_NAME_1     = 'GoodInteractor1';
    const INTERACTOR_NAME_2     = 'GoodInteractor2';

    /** @var DirectoryProcessor */
    private $parser;

    /** @test */
    public function parsedGoodInteractors()
    {
        $map = $this->parser->getInteractorMap();
        $this->assertEquals(2, $map->count());
        $this->assertTrue($map->has(self::INTERACTOR_NAME_1));
        $this->assertTrue($map->has(self::INTERACTOR_NAME_2));
        $this->assertEquals(self::INTERACTOR_CLASS_1, $map->getInteractorClass(self::INTERACTOR_NAME_1));
        $this->assertEquals(self::INTERACTOR_CLASS_2, $map->getInteractorClass(self::INTERACTOR_NAME_2));
    }

    /** {@inheritDoc} */
    protected function setUp()
    {
        parent::setUp();
        $this->parser = new DirectoryProcessor(__DIR__ . '/Interactor');
    }
}
