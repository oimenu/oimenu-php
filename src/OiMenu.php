<?php

namespace OiMenu;

use Exception;

/**
 * Class OiMenu
 * @package OiMenu
 */
class OiMenu
{
    /**
     * @var string The OiMenu API key to be used for requests.
     */
    public static $apiKey;

    /**
     * @var string The base URL for the OiMenu API.
     */
    public static $apiBase = 'https://developers.oimenu.com.br';

    /**
     * @var string|null The version of the OiMenu API to use for requests.
     */
    public static $apiVersion = 'v1';

    /**
     * @var callable|null The version of the OiMenu API to use for requests.
     */
    public static $logHandler = null;

    /**
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public static function getApiBase()
    {
        return self::$apiBase;
    }

    /**
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return null|string
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param null|string $apiVersion
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @param $handler
     * @throws Exception
     */
    public static function registerLogHandler($handler)
    {
        if (!is_callable($handler)) {
            throw new Exception('Log handler must be callable.');
        }

        self::$logHandler = $handler;
    }

    /**
     * @param string $message
     * @param array $data
     */
    public static function log($message, $data = [])
    {
        if (is_callable(self::$logHandler)) {
            call_user_func(self::$logHandler, $message, $data);
        }
    }
}