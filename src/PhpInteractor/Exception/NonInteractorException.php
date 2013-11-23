<?php

namespace PhpInteractor\Exception;

class NonInteractorException extends \Exception
{
    public function __construct($className, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf("Class is not an interactor: %s", $className);
        }

        parent::__construct($message, $code, $previous);
    }
}
