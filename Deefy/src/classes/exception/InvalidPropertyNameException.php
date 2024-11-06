<?php
namespace iutnc\deefy\exception;

class InvalidPropertyNameException extends \Exception {
    public function __construct($message = "Invalid property name", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

