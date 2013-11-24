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

class DependencyCoordinator
{
    /** @var DependencyMap */
    private $globalDependencies;

    /** @var InteractorDependencyMap */
    private $interactorDependencies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->globalDependencies       = new DependencyMap();
        $this->interactorDependencies   = new InteractorDependencyMap();
    }

    /**
     * Get the map of every dependency for an interactor
     *
     * @param string $interactorName
     *
     * @return DependencyMap
     */
    public function getDependencyMap($interactorName)
    {
        $dependencies = new DependencyMap();
        $dependencies->addMap($this->globalDependencies->getDependencyMap());

        if ($this->interactorDependencies->has($interactorName)) {
            $dependencies->addMap($this->interactorDependencies->getDependencyMap($interactorName));
        }

        return $dependencies;
    }

    /**
     * Register a global dependency
     *
     * @param string $dependencyName
     * @param mixed  $dependencyValue
     */
    public function registerGlobalDependency($dependencyName, $dependencyValue)
    {
        $this->globalDependencies->addDependency($dependencyName, $dependencyValue);
    }

    /**
     * Register an interactor-specific dependency
     *
     * @param string $dependencyName
     * @param mixed  $dependencyValue
     * @param string $interactorName
     */
    public function registerInteractorDependency($dependencyName, $dependencyValue, $interactorName)
    {
        if (! $this->globalDependencies->has($dependencyName)) {
            $this->interactorDependencies->addDependency($dependencyName, $dependencyValue, $interactorName);
        }
    }
}
