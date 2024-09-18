<?php
class DataMismatchException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

class NotFoundResults extends Exception
{
    public function __construct($message = "Nenhum resultado encontrado", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

