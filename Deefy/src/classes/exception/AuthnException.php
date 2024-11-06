<?php
namespace iutnc\deefy\exception;

class AuthnException extends \Exception {
    public function __construct($message = "Authentication failed", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
