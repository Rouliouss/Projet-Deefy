<?php
namespace iutnc\deefy\exception;

class InvalidPropertyValueException extends \Exception {
    public function __construct($message = "Invalid property value", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

