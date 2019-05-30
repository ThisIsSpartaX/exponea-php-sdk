<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tauceti\ExponeaApi\Client;

$client = new Client([
    'public_key' => getenv('EXPONEA_PUBLIC_KEY'),
    'private_key' => getenv('EXPONEA_PRIVATE_KEY'),
    'project_token' => getenv('EXPONEA_PROJECT_TOKEN'),
]);
var_dump($client->tracking()->getSystemTime()->wait(true));
