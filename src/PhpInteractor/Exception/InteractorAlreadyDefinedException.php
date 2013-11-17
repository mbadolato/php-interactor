<?php

namespace PhpInteractor\Exception;

class InteractorAlreadyDefinedException extends \Exception
{
    public function __construct($name, $className, $previousClassName, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf("Interactor %s named in class %s was already defined in %s", $name, $className, $previousClassName);
        }

        parent::__construct($message, $code, $previous);
    }
}
