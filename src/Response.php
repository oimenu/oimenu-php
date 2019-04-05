<?php

namespace OiMenu;

/**
 * Class Response
 * @package OiMenu
 */
class Response implements \ArrayAccess
{
    public $httpCode;
    public $responseBody;
    public $requestBody;
    public $requestParams = [];
    public $data = [];
    public $message = '';
    public $errors = [];
    public $count = 0;

    public $success = false;

    /**
     * @param string $responseBody
     */
    public function __construct($responseBody = '')
    {
        if ($responseBody) {
            $this->responseBody = $responseBody;
            $data = json_decode($responseBody, true);

            if (isset($data['data'])) {
                $this->data = $data['data'];
            }

            if (isset($data['message'])) {
                $this->message = $data['message'];
            }

            if (isset($data['errors'])) {
                $this->errors = $data['errors'];
            }

            if (isset($data['count'])) {
                $this->count = $data['count'];
            }

            if (isset($data['success'])) {
                $value = trim($data['success']);
                if (is_string($value)) {
                    $this->success = strcasecmp($value, 'true') == 0 || $value != 0;
                } else {
                    $this->success = (bool)$value;
                }
            }
        }
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return $defaultValue;
    }

    public function debug()
    {
        print_r([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'count' => $this->count,
            'httpCode' => $this->httpCode,
            'requestParams' => $this->requestParams,
            'responseBody' => $this->responseBody,
        ]);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

}
