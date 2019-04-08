<?php

namespace OiMenu;

use Exception;

/**
 * Class Client
 * @package OiMenu
 */
class Client
{
    /**
     * @var string The OiMenu API key to be used for requests.
     */
    protected $apiKey;

    /**
     * @var string The base URL for the OiMenu API.
     */
    protected $apiUrl = 'https://developers.oimenu.com.br';

    /**
     * @var string|null The version of the OiMenu API to use for requests.
     */
    protected $apiVersion = 'v1';

    /**
     * @var callable|null The log function
     */
    protected $logHandler = null;

    /**
     * Client constructor.
     * @param string $token your secret api token
     * @param array $config
     * @throws Exception
     */
    public function __construct($token, $config = [])
    {
        foreach ($config as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
        if (empty($token)) {
            throw new Exception('Missing required parameter token.');
        }

        $this->apiKey = $token;
    }

    /**
     * @param callable $handler
     * @throws Exception
     */
    public function registerLogHandler($handler)
    {
        if (!is_callable($handler)) {
            throw new Exception('Log handler must be callable.');
        }

        $this->logHandler = $handler;
    }

    /**
     * @param string $message
     * @param array $data
     */
    public function log($message, $data = [])
    {
        if (is_callable($this->logHandler)) {
            call_user_func($this->logHandler, $message, $data);
        }
    }

    /**
     * @return Response
     */
    public function getAllOrders()
    {
        return $this->get('orders');
    }

    /**
     * @param string $orderId The id (uuid) that identifies an order to be set as received
     * @return Response
     * @throws Exception
     */
    public function setOrderAsReceived($orderId)
    {
        if (!$orderId) {
            throw new Exception('Invalid param orderId.');
        }

        return $this->put("order/$orderId/received");
    }

    /**
     * @return Response
     */
    public function getAllTables()
    {
        return $this->get('cards');
    }

    /**
     * @param array $table The table data to be created
     * @return Response
     * @throws Exception
     */
    public function createTable($table)
    {
        if (!is_array($table)) {
            throw new Exception('Invalid param table.');
        }

        return $this->post('table', $table);
    }

    /**
     * @param array $tables The tables data list to be created/updated
     * @return Response
     * @throws Exception
     */
    public function batchTables($tables)
    {
        if (!is_array($tables)) {
            throw new Exception('Invalid param tables.');
        }

        return $this->post('tables', $tables);
    }

    /**
     * @param int $code The code that identifies the table
     * @param array $table The data to update
     * @return Response
     * @throws Exception
     */
    public function updateTable($code, $table)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$table) {
            throw new Exception('Invalid param table.');
        }

        return $this->put("table/$code", $table);
    }

    /**
     * @param int $code The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function deleteTable($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->delete("table/$code");
    }

    /**
     * @param int $code The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function closeTable($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->put("table/$code/close");
    }

    /**
     * @param int $code The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function cancelTable($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->put("table/$code/cancel");
    }

    /**
     * @param int $code The code that identifies the table
     * @param string $itemId The id (uuid) that identifies the item to cancel
     * @param null|int $quantity A specific quantity to cancel
     * @return Response
     * @throws Exception
     */
    public function cancelTableItem($code, $itemId, $quantity = null)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }

        $params = null;
        if ($quantity !== null) {
            $params = [
                'quantity' => $quantity
            ];
        }

        return $this->put("table/$code/item/$itemId/cancel", $params);
    }

    /**
     * @param int $code The code that identifies the table
     * @param array $items A list of items to sync
     * @return Response
     * @throws Exception
     */
    public function syncTableItems($code, $items)
    {
        if (!$code) {
            throw new Exception('Invalid code from table.');
        }
        if (!$items) {
            throw new Exception('Invalid items from table.');
        }

        return $this->post("table/$code/items", $items);
    }

    /**
     * @return Response
     */
    public function getAllCards()
    {
        return $this->get('cards');
    }

    /**
     * @param array $card The card data to be created
     * @return Response
     * @throws Exception
     */
    public function createCard($card)
    {
        if (!is_array($card)) {
            throw new Exception('Invalid param card.');
        }

        return $this->post('card', $card);
    }

    /**
     * @param array $cards The cards data list to be created/updated
     * @return Response
     * @throws Exception
     */
    public function batchCards($cards)
    {
        if (!is_array($cards)) {
            throw new Exception('Invalid param cards.');
        }

        return $this->post('cards', $cards);
    }

    /**
     * @param int $code The code that identifies the card
     * @param array $card The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateCard($code, $card)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$card) {
            throw new Exception('Invalid param card.');
        }

        return $this->put("card/$code", $card);
    }

    /**
     * @param int $code The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function deleteCard($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->delete("card/$code");
    }

    /**
     * @param int $code The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function closeCard($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->put("card/$code/close");
    }

    /**
     * @param int $code The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function cancelCard($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->put("card/$code/cancel");
    }

    /**
     * @param int $code The code that identifies the card
     * @param string $itemId The id (uuid) that identifies the item to cancel
     * @param null|int $quantity A specific quantity to cancel
     * @return Response
     * @throws Exception
     */
    public function cancelCardItem($code, $itemId, $quantity = null)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }

        $params = null;
        if ($quantity !== null) {
            $params = [
                'quantity' => $quantity
            ];
        }

        return $this->put("card/$code/item/$itemId/cancel", $params);
    }

    /**
     * @param int $code The code that identifies the card
     * @param array $items A list of items to sync
     * @return Response
     * @throws Exception
     */
    public function syncCardItems($code, $items)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$items) {
            throw new Exception('Invalid param items.');
        }

        return $this->post("card/$code/items", $items);
    }

    /**
     * @return Response
     */
    public function getAllUsers()
    {
        return $this->get('users');
    }

    /**
     * @param array $user The user data to be created
     * @return Response
     * @throws Exception
     */
    public function createUser($user)
    {
        if (!is_array($user)) {
            throw new Exception('Invalid param user.');
        }

        return $this->post('user', $user);
    }

    /**
     * @param array $users The users data list to be created/updated
     * @return Response
     * @throws Exception
     */
    public function batchUsers($users)
    {
        if (!is_array($users)) {
            throw new Exception('Invalid param users.');
        }

        return $this->post('users', $users);
    }

    /**
     * @param string $code The code that identifies the user
     * @param array $user The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateUser($code, $user)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$user) {
            throw new Exception('Invalid param user.');
        }

        return $this->put("user/$code", $user);
    }

    /**
     * @param string $code The code that identifies the user
     * @return Response
     * @throws Exception
     */
    public function deleteUser($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->delete("user/$code");
    }

    /**
     * @return Response
     */
    public function getAllProducts()
    {
        return $this->get('products');
    }

    /**
     * @param array $product The product data to be created
     * @return Response
     * @throws Exception
     */
    public function createProduct($product)
    {
        if (!is_array($product)) {
            throw new Exception('Invalid param product.');
        }

        return $this->post('product', $product);
    }

    /**
     * @param array $products The products data list to be created/updated
     * @return Response
     * @throws Exception
     */
    public function batchProducts($products)
    {
        if (!is_array($products)) {
            throw new Exception('Invalid param products.');
        }

        return $this->post('products', $products);
    }

    /**
     * @param $code string The code that identifies the product
     * @param array $product The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateProduct($code, $product)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }
        if (!$product) {
            throw new Exception('Invalid param product.');
        }

        return $this->put("product/$code", $product);
    }

    /**
     * @param string $code The code that identifies the product
     * @return Response
     * @throws Exception
     */
    public function deleteProduct($code)
    {
        if (!$code) {
            throw new Exception('Invalid param code.');
        }

        return $this->delete("product/$code");
    }

    /**
     * @param $method
     * @param $route
     * @param null|array $params
     * @return Response
     * @throws Exception
     */
    protected function request($method, $route, $params = null)
    {
        $apiUrl = rtrim($this->apiUrl, '/');
        $apiVersion = trim($this->apiVersion, '/');

        $url = "$apiUrl/api/$apiVersion/" . trim($route, '/');

        $this->log("Request $method to $url");

        $headers = [
            "Authorization: Bearer {$this->apiKey}",
            "Content-Type: application/json"
        ];

        $postFields = null;
        if ($params !== null) {
            $postFields = json_encode($params);
            $this->log("Request body is: $postFields");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        $result = curl_exec($ch);

        $response = new Response($result);
        $response->requestMethod = $method;
        $response->requestUrl = $url;
        $response->requestBody = $params;
        $response->responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($result === false) {
            $response->message = curl_error($ch);
            $this->log($response->message);
        } else {
            $this->log("Response is: $result");
        }

        curl_close($ch);

        return $response;
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     */
    protected function get($route, $params = null)
    {
        return $this->request('GET', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     */
    protected function post($route, $params = null)
    {
        return $this->request('POST', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     */
    protected function put($route, $params = null)
    {
        return $this->request('PUT', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     */
    protected function delete($route, $params = null)
    {
        return $this->request('DELETE', $route, $params);
    }
}