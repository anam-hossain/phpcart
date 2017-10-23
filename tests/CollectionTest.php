<?php

namespace Anam\Phpcart\Tests;

use Exception;
use Anam\Phpcart\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public $cart;
    public $item;

    protected function setUp()
    {
        parent::setUp();

        $this->item = [
            'id' => 123,
            'name' => 'T-shirt',
            'price' => 50,
            'quantity' => 2
        ];
    }

    public function testSetItems()
    {
        $collection = new Collection();
        
        $collection->setItems([
            [
                'id' => 125,
                'name' => 'shirt',
                'price' => 500,
                'quantity' => 1
            ], 
            $this->item
        ]);

        $this->assertEquals($this->item, $collection->getItems()[1]);        
    }
}