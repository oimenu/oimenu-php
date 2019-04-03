<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

trait Retrieve
{
    public static function retrieve($id)
    {
        if (!$id) {
            throw new Exception('Invalid param to retrieve.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->get(self::classUrl() . "/$id");
    }
}