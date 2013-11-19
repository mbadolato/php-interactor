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

use PhpInteractor\Exception\NonInteractorException;
use PhpInteractor\Exception\UndeterminedPropertiesException;
use PhpInteractor\Utility\TokenParser\ClassNameTokenParser;
use PhpInteractor\Utility\TokenParser\NamespaceTokenParser;

class Candidate
{
    const NAME_GETTER_METHOD    = 'getName';
    const INTERACTOR_INTERFACE  = 'PhpInteractor\InteractorInterface';

    /** @var string */
    private $className;

    /** @var \SplFileInfo */
    private $file;

    /** @var bool */
    private $isInteractor = null;

    /** @var \ReflectionClass */
    private $reflection;

    /**
     * Constructor
     *
     * @param \SplFileInfo $file
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->file = $file;
        $this->parseClassName();
        $this->reflection = new \ReflectionClass($this->className);
    }

    /**
     * Get the fully qualified class name (note: not the file path)
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Get the interactor name
     *
     * @return mixed
     *
     * @throws Exception\NonInteractorException
     */
    public function getInteractorName()
    {
        if (! $this->isInteractor())
        {
            throw new NonInteractorException($this->file->getFilename());
        }

        $method     = $this->reflection->getMethod(self::NAME_GETTER_METHOD);
        $className  = $this->getClassName();

        return $method->invoke(new $className(), self::NAME_GETTER_METHOD);
    }

    /**
     * Is the file an interactor?
     *
     * @return bool
     */
    public function isInteractor()
    {
        if (is_null($this->isInteractor)) {
            $this->isInteractor = $this->isConcrete() && $this->implementsInteractorInterface();
        }

        return $this->isInteractor;
    }

    private function getFileTokens()
    {
        return token_get_all(file_get_contents($this->file));
    }

    private function  hasValidRequiredComponents($namespace, $className)
    {
        return $namespace && $className;
    }

    private function implementsInteractorInterface()
    {
        return $this->reflection->implementsInterface(self::INTERACTOR_INTERFACE);
    }

    private function isConcrete()
    {
        return ! ($this->reflection->isAbstract() || $this->reflection->isInterface());
    }

    private function parseClassName()
    {
        $tokens     = $this->getFileTokens();
        $namespace  = NamespaceTokenParser::parse($tokens);
        $className  = ClassNameTokenParser::parse($tokens);

        $this->validateParsedData($namespace, $className);
        $this->className = sprintf("%s\\%s", $namespace, $className);
    }

    private function validateParsedData($namespace, $className)
    {
        if (! $this->hasValidRequiredComponents($namespace, $className)) {
            throw new UndeterminedPropertiesException($this->file->getFilename());
        }
    }
}
