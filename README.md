# PHPCart
Simple framework agnostic shopping cart.

## Features

- Simple API
- Support multiple cart instances
- Framework agnostic

## Requirements

- PHP 5.4+

## Installation
PHPCart is available via Composer

```bash
$ composer require anam/phpcart
```

## Laravel Integrations

Use the following dedicated laravel package for PHPCart.

https://github.com/anam-hossain/lara-phpcart

## Usage

### Add Item

The add method required `id`, `name`, `price` and `quantity` keys. However, you can pass any data that your application required.

```php
use Anam\Phpcart\Cart;

$cart = new Cart();

$cart->add([
    'id'       => 1001,
    'name'     => 'Skinny Jeans',
    'quantity' => 1,
    'price'    => 90
]);
```

### Update Item


```php
$cart->update([
    'id'       => 1001,
    'name'     => 'Hoodie'
]);
```

### Update quantity


```php
$cart->updateQty(1001, 3);
```

### Update price

```php
$cart->updatePrice(1001, 30);
```

### Remove an Item

```php
$cart->remove(1001);
```

### Get all Items

```php
$cart->getItems();
// or
$cart->items();
```

### Get an Item

```php
$cart->get(1001);
```

### Determining if an Item exists in the cart

```php
$cart->has(1001);
```

### Get the total number of items in the cart

```php
$cart->count();
```

### Get the total quantities of items in the cart

```php
$cart->totalQuantity();
```

### Total sum

```php
$cart->getTotal();
```

### Empty the cart

```php
$cart->clear();
```

### Multiple carts

PHPCart supports multiple cart instances, so that you can have as many shopping cart instances on the same page as you want without any conflicts. 

```php
$cart = new Cart('cart1');
// or
$cart->setCart('cart2');
$cart->add([
    'id'       => 1001,
    'name'     => 'Skinny Jeans',
    'quantity' => 1,
    'price'    => 90
]);

//or
$cart->named('cart3')->add([
    'id'       => 1001,
    'name'     => 'Jeans',
    'quantity' => 2,
    'price'    => 100
]);
```
