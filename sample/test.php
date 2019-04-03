<?php

require(__DIR__ . '/../init.php');

// define global API key from your account
\OiMenu\OiMenu::setApiKey(getenv('OIMENU_API_KEY'));
\OiMenu\OiMenu::setApiBase('http://developers.oimenu.local');
\OiMenu\OiMenu::registerLogHandler(function ($message, $data) {
    print_r($message . PHP_EOL);
    if ($data) {
        print_r($data);
    }
});

// orders
$response = \OiMenu\Order::all(); // lista todos os pedidos pendentes
$response = \OiMenu\Order::received('036c768b-cdc7-45a9-9e3a-19cacc05ef8b'); // marca um pedido como recebido pelo ERP

// table mode
$response = \OiMenu\Table::close('1'); // fecha o consumo da mesa
$response = \OiMenu\Table::cancel('1'); // cancela o consumo da mesa
$response = \OiMenu\Table::cancelItem('1', 'cb16a4e2-5318-4d75-ab22-d95b9bf39407'); // cancela um item da mesa
$response = \OiMenu\Table::cancelItem('1', '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 1); // cancela uma quantidade específica do item da mesa
$response = \OiMenu\Table::syncItems('1', [
    [
        "code" => "1X1010",
        "name" => "Chocolate",
        "quantity" => "1",
        "price" => 3
    ],
    [
        "code" => "1X2020",
        "name" => "Trident",
        "quantity" => "2",
        "price" => 1.50
    ],
    [
        "id" => "9e734b4c-b158-4a3e-86d2-b2098d1e0473",
        "quantity" => "2",
        "price" => "2.00"
    ]
]); // sincroniza vários itens da mesa

// card mode
$response = \OiMenu\Card::close('57'); // fecha o consumo de uma comanda
$response = \OiMenu\Card::cancel('57'); // cancela o consumo de uma comanda
$response = \OiMenu\Card::cancelItem('57', 'cb16a4e2-5318-4d75-ab22-d95b9bf39407'); // cancela um item da comanda
$response = \OiMenu\Card::cancelItem('57', '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 3); // cancela uma quantidade específica do item da comanda
$response = \OiMenu\Card::syncItems('57', [
    [
        "code" => "1X1010",
        "name" => "Chocolate",
        "quantity" => "1",
        "price" => 3
    ],
    [
        "code" => "1X2020",
        "name" => "Trident",
        "quantity" => "2",
        "price" => 1.50
    ],
    [
        "id" => "9e734b4c-b158-4a3e-86d2-b2098d1e0473",
        "quantity" => "2",
        "price" => "2.00"
    ]
]); // sincroniza vários itens da comanda

// tables
$response = \OiMenu\Table::all(); // lista todas as mesas cadastradas
$response = \OiMenu\Table::create([
    'code' => '13',
    'name' => 'Mesa 13',
    'service_percentage' => '15.5'
]); // cria uma nova mesa
$response = \OiMenu\Table::batch([
    [
        'code' => '14',
        'name' => 'Mesa 14',
        'service_percentage' => '10.00'
    ],
    [
        'code' => '15',
        'name' => 'Mesa 15',
        'service_percentage' => '5.5'
    ],
]); // cria/atualiza várias mesas
$response = \OiMenu\Table::update('13', [
    'service_percentage' => '10'
]); // atualiza uma mesa
$response = \OiMenu\Table::delete('13'); // remove uma mesa

// cards
$response = \OiMenu\Card::all(); // lista todas as comandas cadastradas
$response = \OiMenu\Card::create([
    'code' => '1',
    'qr_code' => '11111',
    'service_percentage' => '11.11'
]); // cria uma nova comanda
$response = \OiMenu\Card::batch([
    [
        'code' => '2',
        'qr_code' => '22222',
        'service_percentage' => '10.00'
    ],
    [
        'code' => '3',
        'qr_code' => '33333',
        'service_percentage' => '5.5'
    ],
]); // cria/atualiza várias comandas
$response = \OiMenu\Card::update('1', [
    'service_percentage' => '10'
]); // atualiza uma comanda
$response = \OiMenu\Card::delete('1'); // remove uma comanda

// users
$response = \OiMenu\User::all(); // lista todos os colaboradores cadastrados
$response = \OiMenu\User::create([
    'code' => '3',
    'name' => 'Fulano',
    'active' => 1
]); // cria um colaborador
$response = \OiMenu\User::batch([
    [
        'code' => '4',
        'name' => 'Sicrano',
        'active' => 1
    ],
    [
        'code' => '5',
        'name' => 'Beltrano',
        'active' => 1
    ]
]); // cria/atualiza vários colaboradores
$response = \OiMenu\User::update('5', [
    'name' => 'Beltrano da Silva',
    'active' => 0
]); // atualiza um colaborador
$response = \OiMenu\User::delete('3'); // remove um colaborador

// erp products
$response = \OiMenu\Product::all(); // lista todos os produtos do ERP
$response = \OiMenu\Product::create([
    'code' => '1006',
    'name' => 'Chopp da Casa 600ml',
    'price' => '6.50',
    'extra_fields' => [
        'any_field' => 1
    ]
]); // cria um produto do ERP
$response = \OiMenu\Product::batch([
    [
        'code' => '1007',
        'name' => 'Chopp 300ml',
        'price' => '5.90',
        'extra_fields' => [
            'any_field' => 2
        ]
    ],
    [
        'code' => '1008',
        'name' => 'Chopp 600ml',
        'price' => '9.90'
    ],
    [
        'code' => '1009',
        'name' => 'Cerveja Artesanal 300ml',
        'price' => '12.00'
    ]
]); // cria/atualiza vários produtos do ERP
$response = \OiMenu\Product::update('1009', [
    'name' => 'Cerveja Artesanal Suave 300ml',
    'price' => '11.90'
]); // atualiza um produto do ERP
$response = \OiMenu\Product::delete('1006'); // remove um produto do ERP