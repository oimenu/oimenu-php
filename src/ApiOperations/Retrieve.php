<?php

namespace OiMenu\ApiOperations;

use OiMenu\Components\ApiRequestor;
use Exception;

/**
 * Trait Retrieve
 * @package OiMenu\ApiOperations
 */
trait Retrieve
{
    /**
     * @param $id
     * @return bool|mixed
     * @throws Exception
     */
    public static function retrieve($id)
    {
        if (!$id) {
            throw new Exception('Invalid param to retrieve.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->get(self::classUrl() . "/$id");
    }
}