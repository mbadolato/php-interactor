<?php

namespace PhpInteractor;

use Assert\Assertion;
use PhpCollection\Map;
use PhpInteractor\Exception\InteractorAlreadyDefinedException;

class InteractorMap
{
    const ERR_NO_CLASS          = 'Interactor class does not exist';
    const ERR_NOT_IMPLEMENTED   = 'InteractorInterface not implemented';
    const INTERACTOR_INTERFACE  = 'PhpInteractor\InteractorInterface';

    /** @var Map */
    private $map;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->map = new Map();
    }

    /**
     * Add an interactor to the map
     *
     * @param string $interactorName
     * @param string $className
     */
    public function add($interactorName, $className)
    {
        $this->validateInteractorNotAlreadyDefined($interactorName, $className);
        $this->validateClass($className);
        $this->map->set($interactorName, $className);
    }

    /**
     * The number of interactors in the map
     *
     * @return int
     */
    public function count()
    {
        return $this->map->count();
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
        return $this->map->get($interactorName)->get();
    }

    /**
     * Does the map contain an interactor of the specified name?
     *
     * @param string $interactorName
     *
     * @return bool
     */
    public function has($interactorName)
    {
        return $this->map->containsKey($interactorName);
    }

    /**
     * Get an iterator for the interactor map
     *
     * @return \ArrayIterator
     */
    public function iterator()
    {
        return $this->map->getIterator();
    }

    private function exception($errorMessage, $className)
    {
        return sprintf('%s: %s', $errorMessage, $className);
    }

    private function isDifferentClass($interactorName, $className)
    {
        return $className != $this->getInteractorClass($interactorName);
    }

    private function validateClass($className)
    {
        Assertion::classExists($className, $this->exception(self::ERR_NO_CLASS, $className));
        Assertion::implementsInterface($className, self::INTERACTOR_INTERFACE, $this->exception(self::ERR_NOT_IMPLEMENTED, $className));
    }

    private function validateInteractorNotAlreadyDefined($interactorName, $className)
    {
        if ($this->has($interactorName) && $this->isDifferentClass($interactorName, $className)) {
            throw new InteractorAlreadyDefinedException($interactorName, $className, $this->getInteractorClass($interactorName));
        }
    }
}
