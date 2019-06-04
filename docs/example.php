<?php

namespace Tauceti\ExponeaApiExample;

require_once __DIR__ . '/../vendor/autoload.php';

use Tauceti\ExponeaApi\Client;
use Tauceti\ExponeaApi\Events\Consent;
use Tauceti\ExponeaApi\Events\Partials\RegisteredCustomer;

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
