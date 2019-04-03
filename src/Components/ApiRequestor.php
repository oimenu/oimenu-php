<?php

namespace OiMenu\Components;

use OiMenu\Exceptions\Api;
use OiMenu\Exceptions\Authentication;
use OiMenu\Exceptions\InvalidRequest;
use OiMenu\OiMenu;

class ApiRequestor
{
    public function request($method, $route, $params = null)
    {
        $apiKey = OiMenu::getApiKey();
        if (!$apiKey) {
            $msg = <<<TEXT
No API key provided. (HINT: set your API key using '"\OiMenu\OiMenu::setApiKey(<API-KEY>)". 
Don't have an API key? Access https://www.oimenu.com.br/contato or email us at desenvolvimento@oimenu.com.br.'
TEXT;

            throw new \OiMenu\Exceptions\Authentication($msg);
        }

        $apiUrl = rtrim(OiMenu::getApiBase(), '/');
        $apiVersion = trim(OiMenu::getApiVersion(), '/');

        $url = "$apiUrl/api/$apiVersion/" . trim($route, '/');

        OiMenu::log("Request $method to $url");

        $headers = [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ];

        $postFields = null;
        if ($params !== null) {
            $postFields = json_encode($params);
            OiMenu::log("Request body is: $postFields");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        if ($response === false) {
            OiMenu::log(curl_error($ch));
            curl_close($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            OiMenu::log("Failure sending the request. Code: $httpCode Response: " . $response);
            throw self::apiError("Failure sending the request.", $httpCode, $response);
        }

        curl_close($ch);

        OiMenu::log("Response is: $response");

        return json_decode($response);
    }

    public function get($route, $params = null)
    {
        return $this->request('GET', $route, $params);
    }

    public function post($route, $params = null)
    {
        return $this->request('POST', $route, $params);
    }

    public function put($route, $params = null)
    {
        return $this->request('PUT', $route, $params);
    }

    public function delete($route, $params = null)
    {
        return $this->request('DELETE', $route, $params);
    }

    private static function apiError($message, $httpCode, $body = null)
    {
        switch ($httpCode) {
            case 401:
                return new Authentication($message, $httpCode, $body);
            case 404:
                return new InvalidRequest($message, $httpCode, $body);
            case 400: // todo
            case 402: // todo
            case 403: // todo
            case 429: // todo
            default:
                return new Api($httpCode, $body);
        }
    }
}