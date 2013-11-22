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

class DependencyMap extends AbstractMap
{
    /**
     * Add a dependency to the map
     *
     * @param string $dependencyName
     * @param mixed  $dependencyValue
     */
    public function addDependency($dependencyName, $dependencyValue)
    {
        $this->add($dependencyName, $dependencyValue);
    }
}
