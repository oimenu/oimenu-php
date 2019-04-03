<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

trait Batch
{
    public static function batch($params)
    {
        if (!is_array($params)) {
            throw new Exception('Invalid params to create batch.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->post(self::classUrl(true), $params);
    }
}