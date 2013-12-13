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

class Dispatcher
{
    const REGISTER_DEPENDENCIES_METHOD  = 'registerDependency';
    const REGISTER_INTERACTORS_METHOD   = 'registerInteractor';

    /** @var DependencyCoordinator */
    private $dependencies;

    /** @var InteractorMap */
    private $interactors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interactors  = new InteractorMap();
        $this->dependencies = new DependencyCoordinator();
    }

    /**
     * Execute an interactor
     *
     * @param InteractorRequestInterface $request
     */
    public function execute(InteractorRequestInterface $request)
    {
        $interactor = $this->getInteractorObject($request);
        $interactor->execute($request);
    }

    /**
     * Get the name of the class that implements an interactor
     *
     * @param string $interactorName The name of the interactor
     *
     * @return string
     */
    public function getClassName($interactorName)
    {
        return $this->interactors->getInteractorClass($interactorName);
    }

    public function getDependencies($interactorName)
    {
        return ($this->isInteractorRegistered($interactorName))
            ? $this->dependencies->getDependencyMap($interactorName)
            : [];
    }

    /**
     * Has an interactor been registered?
     *
     * @param string $interactorName The name of the interactor
     *
     * @return bool
     */
    public function isInteractorRegistered($interactorName)
    {
        return $this->interactors->has($interactorName);
    }

    /**
     * Register a dependency
     *
     * @param string      $dependencyName
     * @param string      $dependencyValue
     * @param string|null $interactorName
     */
    public function registerDependency($dependencyName, $dependencyValue, $interactorName = null)
    {
        $registrationMethodName = $this->getDependencyRegistrationMethodName($interactorName);
        $this->dependencies->$registrationMethodName($dependencyName, $dependencyValue, $interactorName);
    }

    /**
     * Register an interactor
     *
     * @param string $interactorName
     * @param string $className
     */
    public function registerInteractor($interactorName, $className)
    {
        $this->interactors->add($interactorName, $className);
    }

    /**
     * The number of interactors that are presently registered
     *
     * @return int
     */
    public function registeredCount()
    {
        return $this->interactors->count();
    }

    /**
     * Get the name of the registration method to use for registering a dependency
     *
     * @param string $interactorName
     *
     * @return string
     */
    private function getDependencyRegistrationMethodName($interactorName)
    {
        return $interactorName ? DependencyCoordinator::REGISTER_INTERACTOR_METHOD : DependencyCoordinator::REGISTER_GLOBAL_METHOD;
    }

    /**
     * Get the dependency map for an interactor
     *
     * @param InteractorRequestInterface $request
     *
     * @return DependencyMap
     */
    private function getDependencyMap(InteractorRequestInterface $request)
    {
        return $this->dependencies->getDependencyMap($request->getInteractorName());
    }

    /**
     * Get an instantiated interactor object
     *
     * @param InteractorRequestInterface $request
     *
     * @return InteractorInterface
     */
    private function getInteractorObject(InteractorRequestInterface $request)
    {
        $className  = $this->interactors->get($request->getInteractorName());
        $reflection = new \ReflectionClass($className);

        return $reflection->newInstance($request, $this->getDependencyMap($request));
    }
}
