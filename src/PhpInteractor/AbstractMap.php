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

use PhpCollection\Map;

abstract class AbstractMap
{
    /** @var Map */
    protected $map;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->map = new Map();
    }

    /**
     * Add a key value pair to the map, only if the key does not already exist
     *
     * @param string $key
     * @param mixed  $value
     */
    public function add($key, $value)
    {
        if (! $this->has($key)) {
            $this->set($key, $value);
        }
    }

    /**
     * Add another map into this map
     *
     * @param Map $map
     */
    public function addMap(Map $map)
    {
        $this->map->addMap($map);
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
     * Get the value of a map's element
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->map->get($key)->get();
    }

    /**
     * Get the map object
     *
     * @return Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Does the map contain a dependency of the specified name?
     *
     * @param string $dependencyName
     *
     * @return bool
     */
    public function has($dependencyName)
    {
        return $this->map->containsKey($dependencyName);
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

    /**
     * Set the value of a map element, regardless of if the key already exists
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->map->set($key, $value);
    }
}
