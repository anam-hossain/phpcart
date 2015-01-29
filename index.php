<?php
require 'vendor/autoload.php';

use Anam\PhpCart\Cart;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Helpers;

$cart = new Cart(new Session);

echo $cart->store();

dd($cart->get()['test']);
