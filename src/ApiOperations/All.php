<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;

trait All
{
    public static function all()
    {
        $apiRequestor = new ApiRequestor();
        return $apiRequestor->get(self::classUrl(true));
    }
}