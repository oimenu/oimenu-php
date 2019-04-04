<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

/**
 * Trait Update
 * @package OiMenu\ApiOperations
 */
trait Update
{
    /**
     * @param $code
     * @param $params
     * @return bool|mixed
     * @throws Exception
     */
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