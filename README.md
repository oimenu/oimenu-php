# OiMenu PHP SDK

[![Latest Stable Version](https://poser.pugx.org/oimenu/oimenu-php/v/stable)](https://packagist.org/packages/oimenu/oimenu-php)
[![Total Downloads](https://poser.pugx.org/oimenu/oimenu-php/downloads)](https://packagist.org/packages/oimenu/oimenu-php)


## Documentação

Link para a documentação atualizada: [https://developers.oimenu.com.br](https://developers.oimenu.com.br)

## Requisitos

PHP 5.4.0 ou superior.

## Instalação via Composer

O OiMenu SDK está disponível via [Composer](http://getcomposer.org/). Para instalá-lo, execute:

```bash
composer require oimenu/oimenu-php
```

Para utilizar o OiMenu SDK no seu projeto, use o recurso [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading) do Composer:

```php
require_once('vendor/autoload.php');
```

## Instalação Manual

Se você não deseja utilizar o Composer, é possível baixar a última versão em [latest release](https://github.com/oimenu/oimenu-php/releases). Para utilizar o OiMenu SDK, faça o include do arquivo `init.php`.

```php
require_once('/path/to/oimenu-php/init.php');
```

## Dependências

O OiMenu SDK necessita que as seguintes extensões estejam habilitadas para funcionar corretamente:

- [`curl`](https://secure.php.net/manual/en/book.curl.php)
- [`json`](https://secure.php.net/manual/en/book.json.php)

## Utilizando o SDK

Um exemplo de uso do SDK é:

```php
<?php

// definir o token de acesso
$oimenuClient = new \OiMenu\Client('OIMENU-TOKEN');

// listar pedidos pendentes
$response = $oimenuClient->getAllOrders();
if ($response->success) {
    print_r($response->data);
} else {
    echo $response->message . PHP_EOL;
    $response->debug();
}

// cadastrar um produto do ERP
$response = $oimenuClient->createProduct([
    'code' => '1006',
    'name' => 'Chopp da Casa 600ml',
    'price' => '6.50',
    'extra_fields' => [
        'any_field' => 1
    ]
]);
if ($response->success) {
    echo 'O produto foi criado com sucesso.' . PHP_EOL;
} else {
    echo $response->message . PHP_EOL;
    $response->debug();
}
```