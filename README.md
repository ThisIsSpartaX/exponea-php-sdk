# Exponea API SDK for PHP

Library contains only basic functionality which is needed for Exponea integration. If you miss some method, please post merge request as our integration just does not need them. 

Entire library uses asynchronous Guzzle requests. Please keep in mind that every Promise returned by methods must be called with wait() to be executed.

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

### Send purchase

Exponea needs you to send at least two events: Purchase and PurchaseItem (one for every purchase item).

```php
$purchase = new Purchase(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    [
        new Item('012345', 2.99, 1),
    ], // purchase items
    'COD' // payment method
);
$purchaseItem = new PurchaseItem(
    new RegisteredCustomer('example@example.com'),
    'PREFIX12345', // purchase id
    '012345', // item id
    2.99, // price
    2, // quantity
    'SKU012345', // sku (stock keeping unit)
    'Product name',
    new Category('CAT1', 'Some > Category > Breadcrumb')
);
```

You can optionally send voucher used during purchase. Please refer to `$voucher` argument of `Purchase` constructor.

### Get system time

```php
try {
    $systemTime = $client->tracking()->getSystemTime()->wait(); // returns SystemTime object
} catch (...) { ... }
```
