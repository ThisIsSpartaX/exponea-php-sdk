# Changelog

**Version 1.0.0**

- added support for PHP 8.x, bumped minimal version to 7.4
- added support for Guzzle 7.x
- updated missing typings
- usage of Composer 2.x for development purposes
- updated development tools: `phpunit` and `dealerdirect/phpcodesniffer-composer-installer`

**Version 0.0.6**

- new method added for update customer properties

**Version 0.0.5**

- optional discount value and percentage fields for PurchaseItem event
- bugfix: "source" field for Purchase and PurchaseItem should be optional
- bugfix: missing getVoucher method for Purchase event

**Version 0.0.4**

- "source" field for Purchase and PurchaseItem

**Version 0.0.3**

- New events: Purchase and PurchaseItem
- Better tests coverage
