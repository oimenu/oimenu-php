<?php

require(__DIR__ . '/../init.php');

$oimenuClient = new \OiMenu\Client(getenv('OIMENU_API_KEY'));

// show some logs
$oimenuClient->registerLogHandler(function ($message, $data) {
    print_r($message . PHP_EOL);
});

// table mode
$response = $oimenuClient->closeTable(1); // fecha o consumo da mesa
$response->debug();
$response = $oimenuClient->cancelTable(1); // cancela o consumo da mesa
$response->debug();
$response = $oimenuClient->cancelCardItem(1, 'cb16a4e2-5318-4d75-ab22-d95b9bf39407'); // cancela um item da mesa
$response->debug();
$response = $oimenuClient->cancelCardItem(1, '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 1); // cancela uma quantidade específica do item da mesa
$response->debug();
$response = $oimenuClient->syncCardItems(1, [
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
$response->debug();

// card mode
$response = $oimenuClient->closeCard(57); // fecha o consumo de uma comanda
$response->debug();
$response = $oimenuClient->cancelCard(57); // cancela o consumo de uma comanda
$response->debug();
$response = $oimenuClient->cancelCardItem(57, 'cb16a4e2-5318-4d75-ab22-d95b9bf39407'); // cancela um item da comanda
$response->debug();
$response = $oimenuClient->cancelCardItem(57, '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 3); // cancela uma quantidade específica do item da comanda
$response->debug();
$response = $oimenuClient->syncCardItems(57, [
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
$response->debug();

// tables
$response = $oimenuClient->allTables(); // lista todas as mesas cadastradas
$response->debug();
$response = $oimenuClient->createTable([
    'code' => 13,
    'name' => 'Mesa 13',
    'service_percentage' => 15.5
]); // cria uma nova mesa
$response->debug();
$response = $oimenuClient->batchTables([
    [
        'code' => 14,
        'name' => 'Mesa 14',
        'service_percentage' => 10.00
    ],
    [
        'code' => 15,
        'name' => 'Mesa 15',
        'service_percentage' => 5.5
    ],
]); // cria/atualiza várias mesas
$response->debug();
$response = $oimenuClient->updateTable(13, [
    'service_percentage' => 10
]); // atualiza uma mesa
$response->debug();
$response = $oimenuClient->deleteTable(13); // remove uma mesa
$response->debug();

// cards
$response = $oimenuClient->allCards(); // lista todas as comandas cadastradas
$response->debug();
$response = $oimenuClient->createCard([
    'code' => 1,
    'qr_code' => '11111',
    'service_percentage' => 11.11
]); // cria uma nova comanda
$response->debug();
$response = $oimenuClient->batchCards([
    [
        'code' => 2,
        'qr_code' => '22222',
        'service_percentage' => 10.00
    ],
    [
        'code' => 3,
        'qr_code' => '33333',
        'service_percentage' => 5.5
    ],
]); // cria/atualiza várias comandas
$response->debug();
$response = $oimenuClient->updateCard(1, [
    'service_percentage' => 10
]); // atualiza uma comanda
$response->debug();
$response = $oimenuClient->deleteCard(1); // remove uma comanda

// users
$response = $oimenuClient->allUsers(); // lista todos os colaboradores cadastrados
$response->debug();
$response = $oimenuClient->createUser([
    'code' => '3',
    'name' => 'Fulano',
    'active' => 1
]); // cria um colaborador
$response->debug();
$response = $oimenuClient->batchUsers([
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
$response->debug();
$response = $oimenuClient->updateUser('5', [
    'name' => 'Beltrano da Silva',
    'active' => 0
]); // atualiza um colaborador
$response = $oimenuClient->deleteUser('3'); // remove um colaborador
$response->debug();

// erp products
$response = $oimenuClient->allProducts(); // lista todos os produtos do ERP
$response->debug();
$response = $oimenuClient->createProduct([
    'code' => '1006',
    'name' => 'Chopp da Casa 600ml',
    'price' => '6.50',
    'extra_fields' => [
        'any_field' => 1
    ]
]); // cria um produto do ERP
$response->debug();
$response = $oimenuClient->batchProducts([
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
$response->debug();
$response = $oimenuClient->updateProduct('1009', [
    'name' => 'Cerveja Artesanal Suave 300ml',
    'price' => '11.90'
]); // atualiza um produto do ERP
$response->debug();
$response = $oimenuClient->deleteProduct('1006'); // remove um produto do ERP
$response->debug();
