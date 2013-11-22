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

class InteractorDependencyManager
{
    /** @var DependencyMap */
    private $globalDependencies;

    /** @var InteractorDependenciesMap */
    private $interactorDependencies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->globalDependencies       = new DependencyMap();
        $this->interactorDependencies   = new InteractorDependenciesMap();
    }

    /**
     * Add a global dependency
     *
     * @param string $dependencyName
     * @param mixed  $dependencyValue
     */
    public function addGlobalDependency($dependencyName, $dependencyValue)
    {
        $this->globalDependencies->addDependency($dependencyName, $dependencyValue);
    }

    /**
     * Add an interactor-specific dependency
     *
     * @param string $dependencyName
     * @param mixed  $dependencyValue
     * @param string $interactorName
     */
    public function addInteractorDependency($dependencyName, $dependencyValue, $interactorName)
    {
        if (! $this->globalDependencies->has($dependencyName)) {
            $this->interactorDependencies->addDependency($dependencyName, $dependencyValue, $interactorName);
        }
    }

    /**
     * Get the map of every dependency for an interactor
     *
     * @param string $interactorName
     *
     * @return \PhpCollection\Map
     */
    public function getDependencyMap($interactorName)
    {
        $dependencies = new DependencyMap();
        $dependencies->addMap($this->globalDependencies->getDependencyMap());

        if ($this->interactorDependencies->has($interactorName)) {
            $dependencies->addMap($this->interactorDependencies->getDependencyMap($interactorName));
        }

        return $dependencies->getMap();
    }
}