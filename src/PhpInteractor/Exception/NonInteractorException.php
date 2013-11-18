<?php

namespace PhpInteractor\Exception;

class NonInteractorException extends \Exception
{
    public function __construct($filename, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf("Cannot get interactor name on non-interactor class: %s", $filename);
        }

        parent::__construct($message, $code, $previous);
    }
}
