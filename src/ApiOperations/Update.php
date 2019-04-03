<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

trait Update
{
    public static function update($code, $params)
    {
        if (!$code) {
            throw new Exception('Invalid code to update.');
        }

        if (!$params) {
            throw new Exception('Invalid params to update.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->put(self::classUrl() . "/$code", $params);
    }
}