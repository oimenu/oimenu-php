<?php

namespace OiMenu\Exceptions;

use Exception;

class Base extends Exception
{
    public function __construct(
        $message,
        $httpCode = null,
        $response = null
    )
    {
        parent::__construct($message);

        $this->httpCode = $httpCode;
        $this->response = $response;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function getResponse()
    {
        return $this->response;
    }
}