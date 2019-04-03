<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

trait Create
{
    public static function create($params)
    {
        if (!is_array($params)) {
            throw new Exception('Invalid params to create.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->post(self::classUrl(), $params);
    }
}