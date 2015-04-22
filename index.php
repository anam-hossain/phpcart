<?php
require 'vendor/autoload.php';
use Anam\Phpcart\Cart;

$cart = new Cart();

// $cart->add([
//     'id'       => 1003,
//     'name'     => 'Shoes',
//     'quantity' => 2,
//     'price'    => 50
// ]);

$cart->update(['id' => 1001, 'name' => 'Lungi']);
var_dump($cart->getItems());