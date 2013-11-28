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

namespace PhpInteractor;

use PhpInteractor\Exception\UndeterminedPropertiesException;
use Symfony\Component\Finder\Finder;

class DirectoryProcessor
{
    const GET_INTERACTOR_MAP_METHOD = 'getInteractorMap';

    /** @var string */
    private $directory;

    /** @var InteractorMap */
    private $interactorMap;

    /**
     * Constructor
     *
     * @param string $directory The directory to parse for interactor classes
     */
    public function __construct($directory)
    {
        $this->directory        = $directory;
        $this->interactorMap    = new InteractorMap();
        $this->findInteractors();
    }

    /**
     * Get the map of interactors found in the directory structure
     *
     * @return InteractorMap
     */
    public function getInteractorMap()
    {
        return $this->interactorMap;
    }

    private function findFiles()
    {
        $finder = new Finder();

        return $finder->files()->in($this->directory);
    }

    private function findInteractors()
    {
        foreach ($this->findFiles() as $file) {
            try {
                $this->processFile(new Candidate($file));
            } catch (UndeterminedPropertiesException $e) {
                continue;
            }
        }
    }

    private function processFile(Candidate $candidate)
    {
        if ($candidate->isInteractor()) {
            $this->interactorMap->add($candidate->getInteractorName(), $candidate->getClassName());
        }
    }
}
