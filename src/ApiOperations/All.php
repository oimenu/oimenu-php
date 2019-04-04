<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;

/**
 * Trait All
 * @package OiMenu\ApiOperations
 */
trait All
{
    /**
     * @return bool|mixed
     */
    public static function all()
    {
        $apiRequestor = new ApiRequestor();
        return $apiRequestor->get(self::classUrl(true));
    }
}