# Exponea API SDK for PHP

Currently **under development** but core library won't change. If you miss some method, please post merge request
as our integration does not need them. 

Entire library uses asynchronous Guzzle requests. Please keep in mind that every Promise returned by
methods must be called with wait() to be executed.

Public and private key authorization is used in Exponea API so you will need to get 3 values to make valid requests:

- public key
- private key
- project token

Exponea API reference: https://docs.exponea.com/reference

## Usage example
 
Please check following source implementing API intialization and getSystemTime() method:

Usage:
```php
use Tauceti\ExponeaApi\Client;

$client = new Client([
    'public_key' => getenv('EXPONEA_PUBLIC_KEY'),
    'private_key' => getenv('EXPONEA_PRIVATE_KEY'),
    'project_token' => getenv('EXPONEA_PROJECT_TOKEN'),
]);
try {
    $systemTime = $client->tracking()->getSystemTime()->wait(); // returns SystemTime object
} catch (...) { ... }
```

## Tracking API

All methods are contained inside `$client->tracking()` method.

### Set contact agreements (consents)

Both e-mail and SMS agreements are called *consents* in Exponea. They can be granted or revoked.

```php
$event = new Consent(
    new RegisteredCustomer('example@example.com'),
    Consent::CATEGORY_NEWSLETTER,
    Consent::ACTION_GRANT
);
try {
    $client->tracking()->addEvent($event)->wait(); // does not return anything
} catch (...) { ... }
```

### Get system time

```php
try {
    $systemTime = $client->tracking()->getSystemTime()->wait(); // returns SystemTime object
} catch (...) { ... }
```
