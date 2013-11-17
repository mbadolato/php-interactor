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

class InteractorManager
{
    /** @var InteractorMap */
    private $interactorMap;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interactorMap = new InteractorMap();
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
        return $this->interactorMap->getInteractorClass($interactorName);
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
        return $this->interactorMap->has($interactorName);
    }

    /**
     * Register an interactor
     *
     * @param string $interactorName The name of the interactor
     * @param string $className      The class that implements the interactor
     */
    public function register($interactorName, $className)
    {
        $this->interactorMap->add($interactorName, $className);
    }

    /**
     * The number of interactors are presently registered
     *
     * @return int
     */
    public function registeredCount()
    {
        return $this->interactorMap->count();
    }
}
