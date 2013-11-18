<?php

namespace PhpInteractor\Exception;

class UndeterminedPropertiesException extends \Exception
{
    public function __construct($filename, $message = null, \Exception $previous = null, $code = 0)
    {
        if (is_null($message)) {
            $message = sprintf("Could not determine namespace and class name for %s", $filename);
        }

        parent::__construct($message, $code, $previous);
    }
}
