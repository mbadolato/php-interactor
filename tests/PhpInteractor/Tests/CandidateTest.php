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

use PhpInteractor\Candidate;

class CandidateTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function className()
    {
        $candidate = $this->getCandidateFile('GoodInteractor1');
        $this->assertEquals('PhpInteractor\Tests\Interactor\GoodInteractor1', $candidate->getClassName());
    }

    /** @test */
    public function getInteractorNameSuccess()
    {
        $candidate = $this->getCandidateFile('GoodInteractor1');
        $this->assertEquals('GoodInteractor1', $candidate->getInteractorName());
    }

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\NonInteractorException
     */
    public function getInteractorNameFailure()
    {
        $candidate = $this->getCandidateFile('NoInterfaceImplementation');
        $candidate->getInteractorName();
    }

    /**
     * @test
     * @expectedException \PhpInteractor\Exception\UndeterminedPropertiesException
     */
    public function invalidParsedFileData()
    {
        $candidate = $this->getCandidateFile('NoClassDefined');
        $candidate->getInteractorName();
    }

    /** @test */
    public function isInteractor()
    {
        $candidate = $this->getCandidateFile('GoodInteractor1');
        $this->assertTrue($candidate->isInteractor());
    }

    /** @test */
    public function isNotInteractor()
    {
        $candidate = $this->getCandidateFile('NoInterfaceImplementation');
        $this->assertFalse($candidate->isInteractor());
    }

    private function getCandidateFile($file)
    {
        $filePath = sprintf("%s/Interactor/%s.php", __DIR__, $file);

        return new Candidate(new \SplFileInfo($filePath));
    }
}
