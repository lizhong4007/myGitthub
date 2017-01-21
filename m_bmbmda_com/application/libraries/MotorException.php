<?php
class MotorException extends Exception{
    public function __construct($message = 'Unknown exception' , $code = 0) { 
        parent::__construct($message, $code);
    }
    public function __toString() {
        return "<font color='red'>Error:".$this->getMessage()."</font> in File ".$this->getFile()." on Line ".$this->getLine()." ,Error Code : ".$this->getTraceAsString();
    }
}