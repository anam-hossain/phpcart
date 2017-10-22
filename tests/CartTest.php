<?php

namespace Anam\Phpcart\Tests;

use Exception;
use InvalidArgumentException;
use Anam\Phpcart\Cart;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

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

        $cart = $cart->named('test2');

         $this->assertEquals('test2_cart', $cart->getCart(), 'Set cart name using named() method');        
    }

    public function testInvalidCartName()
    {
        $cart = new Cart();

        $cart->setCart('test');

        $this->assertNotEquals('Cart123', $cart->getCart());
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionOnInvalidCartItem()
    {
        $cart = new Cart('test');

        $cart->add(['id' => '123']);
    }

    public function testAddCartItem()
    {
        $cart = new Cart('test', new MockArraySessionStorage());

        $item = [
            'id' => 123,
            'name' => 'T-shirt',
            'price' => 50,
            'quantity' => 2
        ];

        $cartItems = $cart->add($item);

        $this->assertEquals($item, (array) $cartItems->first());        
    }
}