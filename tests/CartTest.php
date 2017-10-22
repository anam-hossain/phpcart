<?php

namespace Anam\Phpcart\Tests;

use Exception;
use InvalidArgumentException;
use Anam\Phpcart\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentExceptionOnInvalidCartName()
    {
        $cart = new Cart();

        $cart->setCart('');
    }

    public function testCartName()
    {
        $cart = new Cart('test');

        $this->assertEquals('test_cart', $cart->getCart());
    }
}