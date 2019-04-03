<?php

// OiMenu singleton
require(dirname(__FILE__) . '/src/OiMenu.php');

// OiMenu components
require(dirname(__FILE__) . '/src/Components/ApiRequestor.php');
require(dirname(__FILE__) . '/src/Components/ApiResource.php');

// OiMenu API operations
require(dirname(__FILE__) . '/src/ApiOperations/All.php');
require(dirname(__FILE__) . '/src/ApiOperations/Retrieve.php');
require(dirname(__FILE__) . '/src/ApiOperations/Create.php');
require(dirname(__FILE__) . '/src/ApiOperations/Batch.php');
require(dirname(__FILE__) . '/src/ApiOperations/Update.php');
require(dirname(__FILE__) . '/src/ApiOperations/Delete.php');

// OiMenu errors
require(dirname(__FILE__) . '/src/Exceptions/Base.php');
require(dirname(__FILE__) . '/src/Exceptions/Api.php');
require(dirname(__FILE__) . '/src/Exceptions/Authentication.php');
require(dirname(__FILE__) . '/src/Exceptions/InvalidRequest.php');

// OiMenu API resources
require(dirname(__FILE__) . '/src/Order.php');
require(dirname(__FILE__) . '/src/Table.php');
require(dirname(__FILE__) . '/src/Card.php');
require(dirname(__FILE__) . '/src/User.php');
require(dirname(__FILE__) . '/src/Product.php');
