<?php

namespace OiMenu\Exceptions;

use Exception;

/**
 * Class Base
 * @package OiMenu\Exceptions
 */
class Base extends Exception
{
    /**
     * Base constructor.
     * @param string $message
     * @param null $httpCode
     * @param null $response
     */
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

    /**
     * @return null
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }
}