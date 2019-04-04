<?php

namespace OiMenu;

use OiMenu\ApiOperations\All;
use OiMenu\Components\ApiRequestor;
use OiMenu\Components\ApiResource;
use Exception;

/**
 * Class Order
 * @package OiMenu
 */
class Order extends ApiResource
{
    const OBJECT_NAME = 'order';

    use All;

    /**
     * @param $id
     * @return bool|mixed
     * @throws Exception
     */
    public static function received($id)
    {
        if (!$id) {
            throw new Exception('Invalid id from order.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->put("order/$id/received");
    }
}