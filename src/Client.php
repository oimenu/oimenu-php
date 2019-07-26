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
     * @var string|null The version of the OiMenu API to be used for requests.
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
     * @throws Exception
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
     * @throws Exception
     */
    public function getAllEvents()
    {
        return $this->get('events');
    }

    /**
     * @param string $eventId
     * @return Response
     * @throws Exception
     */
    public function setEventAsReceived($eventId)
    {
        if (!$eventId) {
            throw new Exception('Invalid param eventId.');
        }

        return $this->put("event/$eventId/received");
    }

    /**
     * @return Response
     * @throws Exception
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
     * @param int $tableCode The code that identifies the table
     * @param array $table The data to update
     * @return Response
     * @throws Exception
     */
    public function updateTable($tableCode, $table)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }
        if (!$table) {
            throw new Exception('Invalid param table.');
        }

        return $this->put("table/$tableCode", $table);
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function deleteTable($tableCode)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }

        return $this->delete("table/$tableCode");
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function closeTable($tableCode)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }

        return $this->put("table/$tableCode/close");
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function cancelTable($tableCode)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }

        return $this->put("table/$tableCode/cancel");
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @return Response
     * @throws Exception
     */
    public function reopenTable($tableCode)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }

        return $this->put("table/$tableCode/reopen");
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @param array $item The item data to be created
     * @return Response
     * @throws Exception
     */
    public function createTableItem($tableCode, $item)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }
        if (!is_array($item)) {
            throw new Exception('Invalid param item.');
        }

        return $this->post("table/$tableCode/item", $item);
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @param string $itemId The id that identifies the item to update
     * @param array $item The item data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateTableItem($tableCode, $itemId, $item)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }
        if (!is_array($item)) {
            throw new Exception('Invalid param item.');
        }

        return $this->put("table/$tableCode/item/$itemId", $item);
    }

    /**
     * @param int $tableCode The code that identifies the table
     * @param string $itemId The id that identifies the item to cancel
     * @param int|null $quantity A specific quantity to cancel
     * @return Response
     * @throws Exception
     */
    public function cancelTableItem($tableCode, $itemId, $quantity = null)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
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

        return $this->put("table/$tableCode/item/$itemId/cancel", $params);
    }

    /**
     * @param int $tableCode The code that identifies the current table
     * @param int $newTableCode The code that identifies the destination table
     * @return Response
     * @throws Exception
     */
    public function transferTable($tableCode, $newTableCode)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }
        if (!$newTableCode) {
            throw new Exception('Invalid param newTableCode.');
        }

        return $this->put("table/$tableCode/transfer", [
            'new_table' => $newTableCode
        ]);
    }

    /**
     * @param int $tableCode The code that identifies the current table
     * @param int $newTableCode The code that identifies the destination table
     * @param string $itemId The id that identifies the item to be transferred
     * @param int|null $quantity The quantity to be transferred
     * @return Response
     * @throws Exception
     */
    public function transferTableItem($tableCode, $newTableCode, $itemId, $quantity = null)
    {
        if (!$tableCode) {
            throw new Exception('Invalid param tableCode.');
        }
        if (!$newTableCode) {
            throw new Exception('Invalid param newTableCode.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }
        if ($quantity !== null && !is_numeric($quantity)) {
            throw new Exception('Invalid param quantity.');
        }

        $params = [
            'new_table' => $newTableCode,
        ];
        if ($quantity !== null) {
            $params['quantity'] = $quantity;
        }

        return $this->put("table/$tableCode/item/$itemId/transfer", $params);
    }

    /**
     * @return Response
     * @throws Exception
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
     * @param int $cardCode The code that identifies the card
     * @param array $card The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateCard($cardCode, $card)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }
        if (!$card) {
            throw new Exception('Invalid param card.');
        }

        return $this->put("card/$cardCode", $card);
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function deleteCard($cardCode)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }

        return $this->delete("card/$cardCode");
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function closeCard($cardCode)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }

        return $this->put("card/$cardCode/close");
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function cancelCard($cardCode)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }

        return $this->put("card/$cardCode/cancel");
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @return Response
     * @throws Exception
     */
    public function reopenCard($cardCode)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }

        return $this->put("card/$cardCode/reopen");
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @param array $item The item data to be created
     * @return Response
     * @throws Exception
     */
    public function createCardItem($cardCode, $item)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }
        if (!is_array($item)) {
            throw new Exception('Invalid param item.');
        }

        return $this->post("card/$cardCode/item", $item);
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @param string $itemId The id that identifies the item to update
     * @param array $item The item data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateCardItem($cardCode, $itemId, $item)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }
        if (!is_array($item)) {
            throw new Exception('Invalid param item.');
        }

        return $this->put("card/$cardCode/item/$itemId", $item);
    }

    /**
     * @param int $cardCode The code that identifies the card
     * @param string $itemId The id that identifies the item to cancel
     * @param int|null $quantity A specific quantity to cancel
     * @return Response
     * @throws Exception
     */
    public function cancelCardItem($cardCode, $itemId, $quantity = null)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
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

        return $this->put("card/$cardCode/item/$itemId/cancel", $params);
    }

    /**
     * @param int $cardCode The code that identifies the current card
     * @param int $newCardCode The code that identifies the destination card
     * @return Response
     * @throws Exception
     */
    public function transferCard($cardCode, $newCardCode)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }
        if (!$newCardCode) {
            throw new Exception('Invalid param newCardCode.');
        }

        return $this->put("card/$cardCode/transfer", [
            'new_card' => $newCardCode
        ]);
    }

    /**
     * @param int $cardCode The code that identifies the current card
     * @param int $newCardCode The code that identifies the destination card
     * @param string $itemId The item id that identifies the item to be transferred
     * @param int|null $quantity The quantity to be transferred
     * @return Response
     * @throws Exception
     */
    public function transferCardItem($cardCode, $newCardCode, $itemId, $quantity = null)
    {
        if (!$cardCode) {
            throw new Exception('Invalid param cardCode.');
        }
        if (!$newCardCode) {
            throw new Exception('Invalid param newCardCode.');
        }
        if (!$itemId) {
            throw new Exception('Invalid param itemId.');
        }
        if ($quantity !== null && !is_numeric($quantity)) {
            throw new Exception('Invalid param quantity.');
        }

        $params = [
            'new_card' => $newCardCode,
        ];
        if ($quantity !== null) {
            $params['quantity'] = $quantity;
        }

        return $this->put("card/$cardCode/item/$itemId/transfer", $params);
    }

    /**
     * @return Response
     * @throws Exception
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
     * @param string $userCode The code that identifies the user
     * @param array $user The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateUser($userCode, $user)
    {
        if (!$userCode) {
            throw new Exception('Invalid param userCode.');
        }
        if (!$user) {
            throw new Exception('Invalid param user.');
        }

        return $this->put("user/$userCode", $user);
    }

    /**
     * @param string $userCode The code that identifies the user
     * @return Response
     * @throws Exception
     */
    public function deleteUser($userCode)
    {
        if (!$userCode) {
            throw new Exception('Invalid param userCode.');
        }

        return $this->delete("user/$userCode");
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
     * @param string $productCode The code that identifies the product
     * @param array $product The data to be updated
     * @return Response
     * @throws Exception
     */
    public function updateProduct($productCode, $product)
    {
        if (!$productCode) {
            throw new Exception('Invalid param productCode.');
        }
        if (!$product) {
            throw new Exception('Invalid param product.');
        }

        return $this->put("product/$productCode", $product);
    }

    /**
     * @param string $productCode The code that identifies the product
     * @return Response
     * @throws Exception
     */
    public function deleteProduct($productCode)
    {
        if (!$productCode) {
            throw new Exception('Invalid param productCode.');
        }

        return $this->delete("product/$productCode");
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
     * @throws Exception
     */
    protected function get($route, $params = null)
    {
        return $this->request('GET', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     * @throws Exception
     */
    protected function post($route, $params = null)
    {
        return $this->request('POST', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     * @throws Exception
     */
    protected function put($route, $params = null)
    {
        return $this->request('PUT', $route, $params);
    }

    /**
     * @param $route
     * @param null|array $params
     * @return Response
     * @throws Exception
     */
    protected function delete($route, $params = null)
    {
        return $this->request('DELETE', $route, $params);
    }
}