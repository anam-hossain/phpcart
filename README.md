# PHPCart

## Features

- Simple API
- Support multiple cart instances
- Framework agnostic, with optional Laravel integration

## Requirements

- PHP 5.4+

## Installation
PHPCart is available via Composer

```bash
$ composer require anam/phpcart
```

## Integrations

Laravel 4 and Laravel 5 integrations

Although PHPCart is framework agnostic, it does support Laravel out of the box and comes with a Service provider and Facade for easy integration.

After you have installed the PHPCart, open the config/app.php file which is included with Laravel and add the following lines.

In the $providers array add the following service provider.

```php
'Anam\Phpcart\CartServiceProvider'
```

Add the facade of this package to the $aliases array.

```php
'Cart' => 'Anam\Phpcart\Facades\Cart'
```

You can now use this facade in place of instantiating the Cart yourself in the following examples.

## Usage