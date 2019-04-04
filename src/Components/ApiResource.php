<?php

namespace OiMenu\Components;

/**
 * Class ApiResource
 * @package OiMenu\Components
 */
class ApiResource
{
    /**
     * @param bool $plural
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl($plural = false)
    {
        return str_replace('.', '/', static::OBJECT_NAME) . ($plural ? 's' : '');
    }
}