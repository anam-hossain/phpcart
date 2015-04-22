<?php
require 'vendor/autoload.php';

use Anam\Phpcart\Cart;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Helpers;

$cart = new Cart('anam');

$cart->add(['id' => 1, 'name' => 'Hello']);

var_dump($cart->getItems());
