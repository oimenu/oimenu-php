<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

trait Delete
{
    public static function delete($code)
    {
        if (!$code) {
            throw new Exception('Invalid code to delete.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->delete(self::classUrl() . "/$code");
    }
}