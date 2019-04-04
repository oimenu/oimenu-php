<?php

namespace OiMenu;

use OiMenu\ApiOperations\All;
use OiMenu\ApiOperations\Create;
use OiMenu\ApiOperations\Batch;
use OiMenu\ApiOperations\Delete;
use OiMenu\ApiOperations\Update;
use OiMenu\Components\ApiResource;

/**
 * Class User
 * @package OiMenu
 */
class User extends ApiResource
{
    const OBJECT_NAME = 'user';

    use All;
    use Create;
    use Batch;
    use Update;
    use Delete;
}