# Exponea API SDK for PHP

Currently **under development** (supports only GET /system/time method from Tracking API).

Usage:
```php
use Tauceti\ExponeaApi\Client;

$client = new Client([
    'public_key' => getenv('EXPONEA_PUBLIC_KEY'),
    'private_key' => getenv('EXPONEA_PRIVATE_KEY'),
    'project_token' => getenv('EXPONEA_PROJECT_TOKEN'),
]);
try {
    $systemTime = $client->tracking()->getSystemTime()->wait(true);
} catch (...) { ... }
```