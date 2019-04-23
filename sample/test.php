<?php

require(__DIR__ . '/../init.php');

$oimenuClient = new \OiMenu\Client(getenv('OIMENU_API_KEY'));

// show some logs
$oimenuClient->registerLogHandler(function ($message, $data) {
    print_r($message . PHP_EOL);
});

// PEDIDOS
// lista todos os pedidos pendentes
$response = $oimenuClient->getAllOrders();
$response->debug();
// marca um pedido como recebido pelo ERP
$response = $oimenuClient->setOrderAsReceived('036c768b-cdc7-45a9-9e3a-19cacc05ef8b');
$response->debug();

// NO MODO MESA
// fecha o consumo da mesa
$response = $oimenuClient->closeTable(1);
$response->debug();
// cancela o consumo da mesa
$response = $oimenuClient->cancelTable(1);
$response->debug();
// transfere uma mesa para outra
$response = $oimenuClient->transferTable(1, 2);
$response->debug();
// adiciona um item à uma mesa
$response = $oimenuClient->createTableItem(1, [
    'code' => 100,
    'name' => 'Bala de coco X',
    'quantity' => 2,
    'price' => 2.5
]);
$response->debug();
// atualiza um item de uma mesa
$response = $oimenuClient->updateTableItem(1, '470f150f-548f-453e-b12d-af4606b2621e', [
    'name' => 'Bala de coco',
    'quantity' => 2
]);
$response->debug();
// cancela um item da mesa
$response = $oimenuClient->cancelTableItem(1, 'cb16a4e2-5318-4d75-ab22-d95b9bf39407');
$response->debug();
// cancela uma quantidade específica do item da mesa
$response = $oimenuClient->cancelTableItem(1, '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 1);
$response->debug();
// transfere  um item de uma mesa para outra
$response = $oimenuClient->transferTableItem(4, 5, '942e7697-60cd-4f93-8267-8c0475427c63');
$response->debug();
// transfere uma quantidade específica de um item de uma mesa para outra
$response = $oimenuClient->transferTableItem(6, 5, '48f77fec-a805-43c0-aa11-98d1ae287c14', 2);
$response->debug();

// NO MODO COMANDA
// fecha o consumo de uma comanda
$response = $oimenuClient->closeCard(57);
$response->debug();
// cancela o consumo de uma comanda
$response = $oimenuClient->cancelCard(57);
$response->debug();
// transfere o consumo de uma comanda para outra
$response = $oimenuClient->transferCard(2, 5);
$response->debug();
// adiciona um item à uma comanda
$response = $oimenuClient->createCardItem(57, [
    'code' => 100,
    'name' => 'Bala de coco X',
    'quantity' => 1,
    'price' => 2.5
]);
$response->debug();
// atualiza o item de uma comanda
$response = $oimenuClient->updateCardItem(57, '470f150f-548f-453e-b12d-af4606b2621e', [
    'name' => 'Bala de coco',
    'quantity' => 2
]);
$response->debug();
// cancela um item da comanda
$response = $oimenuClient->cancelCardItem(57, 'cb16a4e2-5318-4d75-ab22-d95b9bf39407');
$response->debug();
// cancela uma quantidade específica do item da comanda
$response = $oimenuClient->cancelCardItem(57, '9e734b4c-b158-4a3e-86d2-b2098d1e0473', 3);
$response->debug();
// transfere um item de uma comanda para outra
$response = $oimenuClient->transferCardItem(7, 6, '79ea0be4-2b94-4b3a-812a-ed02fce4636e');
$response->debug();
// transfere uma quantidade específica de um item de uma comanda para outra
$response = $oimenuClient->transferCardItem(3, 7, '1ce8eff4-cd1a-45f3-803b-a1a698220e91', 4);
$response->debug();

// CADASTRO DE MESAS
// lista todas as mesas cadastradas
$response = $oimenuClient->getAllTables();
$response->debug();
// cria uma nova mesa
$response = $oimenuClient->createTable([
    'code' => 13,
    'name' => 'Mesa 13',
    'service_percentage' => 15.5
]);
$response->debug();
// cria/atualiza várias mesas
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
]);
$response->debug();
// atualiza uma mesa
$response = $oimenuClient->updateTable(13, [
    'service_percentage' => 10
]);
$response->debug();
// remove uma mesa
$response = $oimenuClient->deleteTable(13);
$response->debug();

// CADASTRO DE COMANDAS
// lista todas as comandas cadastradas
$response = $oimenuClient->getAllCards();
$response->debug();
// cria uma nova comanda
$response = $oimenuClient->createCard([
    'code' => 1,
    'qr_code' => '11111',
    'service_percentage' => 11.11
]);
$response->debug();
// cria/atualiza várias comandas
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
]);
$response->debug();
// atualiza uma comanda
$response = $oimenuClient->updateCard(1, [
    'service_percentage' => 10
]);
$response->debug();
// remove uma comanda
$response = $oimenuClient->deleteCard(1);
$response->debug();

// CADASTRO DE COLABORADORES
// lista todos os colaboradores cadastrados
$response = $oimenuClient->getAllUsers();
$response->debug();
// cria um colaborador
$response = $oimenuClient->createUser([
    'code' => '3',
    'name' => 'Fulano',
    'email' => 'fulano@gmail.com',
    'password' => 1234,
    'role' => 'admin',
    'active' => 1
]);
$response->debug();
// cria/atualiza vários colaboradores
$response = $oimenuClient->batchUsers([
    [
        'code' => '4',
        'name' => 'Sicrano',
        'role' => 'waiter',
        'active' => 1
    ],
    [
        'code' => '5',
        'name' => 'Beltrano',
        'role' => 'cashier',
        'active' => 1
    ]
]);
$response->debug();
// atualiza um colaborador
$response = $oimenuClient->updateUser('5', [
    'name' => 'Beltrano da Silva',
    'active' => 0
]);
// remove um colaborador
$response = $oimenuClient->deleteUser('3');
$response->debug();

// CADASTRO DE PRODUTOS DO ERP
// lista todos os produtos do ERP
$response = $oimenuClient->getAllProducts();
$response->debug();
// cria um produto do ERP
$response = $oimenuClient->createProduct([
    'code' => '1006',
    'name' => 'Chopp da Casa 600ml',
    'price' => '6.50',
    'extra_fields' => [
        'any_field' => 1
    ]
]);
$response->debug();
// cria/atualiza vários produtos do ERP
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
]);
$response->debug();
// atualiza um produto do ERP
$response = $oimenuClient->updateProduct('1009', [
    'name' => 'Cerveja Artesanal Suave 300ml',
    'price' => '11.90'
]);
$response->debug();
// remove um produto do ERP
$response = $oimenuClient->deleteProduct('1006');
$response->debug();
