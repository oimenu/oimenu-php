<?php

namespace OiMenu;

use OiMenu\ApiOperations\All;
use OiMenu\ApiOperations\Create;
use OiMenu\ApiOperations\Batch;
use OiMenu\ApiOperations\Delete;
use OiMenu\ApiOperations\Update;
use OiMenu\Components\ApiRequestor;
use OiMenu\Components\ApiResource;
use Exception;

/**
 * Class Card
 * @package OiMenu
 */
class Card extends ApiResource
{
    const OBJECT_NAME = 'card';

    use All;
    use Create;
    use Batch;
    use Update;
    use Delete;

    /**
     * @param $code
     * @return bool|mixed
     * @throws Exception
     */
    public static function close($code)
    {
        if (!$code) {
            throw new Exception('Invalid code from card.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->put(self::classUrl() . "/$code/close");
    }

    /**
     * @param $code
     * @return bool|mixed
     * @throws Exception
     */
    public static function cancel($code)
    {
        if (!$code) {
            throw new Exception('Invalid code from card.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->put(self::classUrl() . "/$code/cancel");
    }

    /**
     * @param $code
     * @param $itemId
     * @param null $quantity
     * @return bool|mixed
     * @throws Exception
     */
    public static function cancelItem($code, $itemId, $quantity = null)
    {
        if (!$code) {
            throw new Exception('Invalid code from card.');
        }
        if (!$itemId) {
            throw new Exception('Invalid itemId from card.');
        }

        $params = null;
        if ($quantity !== null) {
            $params = [
                'quantity' => $quantity
            ];
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->put(self::classUrl() . "/$code/item/$itemId/cancel", $params);
    }

    /**
     * @param $code
     * @param $params
     * @return bool|mixed
     * @throws Exception
     */
    public static function syncItems($code, $params)
    {
        if (!$code) {
            throw new Exception('Invalid code from card.');
        }
        if (!$params) {
            throw new Exception('Invalid params from card.');
        }

        $apiRequestor = new ApiRequestor();
        return $apiRequestor->post(self::classUrl() . "/$code/items", $params);
    }
}