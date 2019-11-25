<?php

namespace Tauceti\ExponeaApiExample;

require_once __DIR__ . '/../vendor/autoload.php';

use Tauceti\ExponeaApi\Client;
use Tauceti\ExponeaApi\Events\Consent;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;
use Tauceti\ExponeaApi\Events\Purchase;
use Tauceti\ExponeaApi\Events\PurchaseItem;
use Tauceti\ExponeaApi\Events\Partials\Category;
use Tauceti\ExponeaApi\Events\Partials\Item;

$client = new Client([
    'public_key' => getenv('EXPONEA_PUBLIC_KEY'),
    'private_key' => getenv('EXPONEA_PRIVATE_KEY'),
    'project_token' => getenv('EXPONEA_PROJECT_TOKEN'),
]);
var_dump($client->tracking()->getSystemTime()->wait());

$event = new Consent(
    new RegisteredCustomer('example@example.com'),
    Consent::CATEGORY_NEWSLETTER,
    Consent::ACTION_GRANT
);
var_dump($client->tracking()->addEvent($event)->wait());

$event = new Purchase(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    [
        new Item('012345', 2.99, 2),
    ], // purchase items
    'COD' // payment method
);
var_dump($client->tracking()->addEvent($event)->wait());

$event = new PurchaseItem(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    '012345', // item id
    2.99, // price
    2, // quantity
    'SKU012345', // sku (stock keeping unit)
    'Product name',
    new Category('CAT1', 'Some > Category > Breadcrumb')
);
var_dump($client->tracking()->addEvent($event)->wait());

var_dump($client->tracking()->updateCustomerProperties(
    new RegisteredCustomer('example@example.com'),
    ['fidelity_points' => 35]
)->wait());

var_dump($client->tracking()->updateCustomerProperties(
    new RegisteredCustomer(
        'lukasz.rutkowski@tauceti.email',
        ['card_id' => '111']
    ),
    []
)->wait());
