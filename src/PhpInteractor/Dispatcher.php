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
    const REGISTER_DEPENDENCIES_METHOD  = 'setDependencyCoordinator';
    const REGISTER_INTERACTORS_METHOD   = 'setInteractorMap';

    /** @var DependencyCoordinator */
    private $dependencies;

    /** @var InteractorMap */
    private $interactors;

    /**
     * Constructor
     */
    public function __construct(InteractorMap $interactors, DependencyCoordinator $dependencies)
    {
        $this->setInteractorMap($interactors);
        $this->setDependencyCoordinator($dependencies);
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

    /**
     * Has an interactor been registered?
     *
     * @param string $interactorName The name of the interactor
     *
     * @return bool
     */
    public function isRegistered($interactorName)
    {
        return $this->interactors->has($interactorName);
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

    public function setDependencyCoordinator(DependencyCoordinator $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public function setInteractorMap(InteractorMap $interactors)
    {
        $this->interactors = $interactors;
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
