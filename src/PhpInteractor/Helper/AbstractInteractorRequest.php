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

namespace PhpInteractor\Helper;

use PhpInteractor\Exception\MissingPropertyException;
use PhpInteractor\InteractorRequestInterface;

abstract class AbstractInteractorRequest implements InteractorRequestInterface
{
    public function __construct(array $parameters)
    {
        $this->processProperties($parameters);
    }

    /** {@inheritDoc} */
    public function getInteractorName()
    {
        $parts = $this->getClassNameComponents();

        return preg_replace('/Request$/', '', end($parts));
    }

    private function getClassNameComponents()
    {
        return explode('\\', get_class($this));
    }

    private function processProperties(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->validateProperty($key);
            $this->$key = $value;
        }
    }

    private function validateProperty($property)
    {
        if (! property_exists($this, $property)) {
            throw new MissingPropertyException($property, $this->getInteractorName());
        }
    }
}
