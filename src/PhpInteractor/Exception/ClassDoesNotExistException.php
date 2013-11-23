<?php

namespace PhpInteractor\Exception;

class ClassDoesNotExistException extends \Exception
{
    public function __construct($className, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf('Interactor class does not exist: %s', $className);
        }

        parent::__construct($message, $code, $previous);
    }
}
