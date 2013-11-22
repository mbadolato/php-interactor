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

use Assert\Assertion;
use PhpInteractor\Exception\InteractorAlreadyDefinedException;

class InteractorMap extends AbstractMap
{
    const ERR_NO_CLASS          = 'Interactor class does not exist';
    const ERR_NOT_IMPLEMENTED   = 'InteractorInterface not implemented';
    const INTERACTOR_INTERFACE  = 'PhpInteractor\InteractorInterface';

    /**
     * Add an interactor to the map
     *
     * @param string $interactorName
     * @param string $className
     */
    public function add($interactorName, $className)
    {
        if (! $this->definitionExists($interactorName, $className)) {
            $this->validate($interactorName, $className);
            $this->set($interactorName, $className);
        }
    }

    /**
     * Get the name of the class mapped to an interactor
     *
     * @param string $interactorName
     *
     * @return string
     */
    public function getInteractorClass($interactorName)
    {
        return $this->get($interactorName);
    }

    private function definitionExists($interactorName, $className)
    {
        return $this->has($interactorName) && $this->isSameClass($interactorName, $className);
    }

    private function isSameClass($interactorName, $className)
    {
        return $className == $this->getInteractorClass($interactorName);
    }

    private function validate($interactorName, $className)
    {
        if ($this->has($interactorName)) {
            throw new InteractorAlreadyDefinedException($interactorName, $className, $this->getInteractorClass($interactorName));
        }

        Assertion::classExists($className, $this->exception(self::ERR_NO_CLASS, $className));
        Assertion::implementsInterface($className, self::INTERACTOR_INTERFACE, $this->exception(self::ERR_NOT_IMPLEMENTED, $className));
    }
}
