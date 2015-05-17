<?php
namespace Anam\Phpcart;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart implements CartInterface
{
    const CARTSUFFIX = '_cart';

    /**
     * The Cart session,
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    protected $session;

    /**
     * Manage cart items
     *
     * @var \Anam\Phpcart\Collection
     */
    protected $collection;

    /**
     * Cart name
     *
     * @var string
     */
    protected $name = "phpcart";

    /**
     * Construct the class.
     *
     * @return void
     */
    public function __construct($name = null)
    {
        $this->session = new Session();
        $this->collection = new Collection();

        if ($name) {
            $this->setCart($name);
        }
    }

    public function setCart($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Cart name can not be empty.');
        }

        $this->name = $name . self::CARTSUFFIX;
    }

    public function getCart()
    {
        return $this->name;
    }

    /**
     * Set the current cart name
     *
     * @param  string  $instance  Cart instance name
     * @return \Anam\Phpcart\Cart
     */
    public function named($name)
    {
        $this->setCart($name);

        return $this;
    }

    /**
     * Add an item to the cart.
     *
     * @param  Array  $product
     * @return \Anam\Phpcart\Collection
     */
    public function add(Array $product)
    {
        $this->collection->validateItem($product);

        // If item already added, increment the quantity
        if ($this->has($product['id'])) {
            $item = $this->get($product['id']);

            return $this->updateQty($item->id, $item->quantity + $product['quantity']);
        }

        $this->collection->setItems($this->session->get($this->getCart(), []));

        $items = $this->collection->insert($product);

        $this->session->set($this->getCart(), $items);

        return $this->collection->make($items);
    }

    /**
     * Update an item.
     *
     * @param  Array  $product
     * @return \Anam\Phpcart\Collection
     */
    public function update(Array $product)
    {
        $this->collection->setItems($this->session->get($this->getCart(), []));

        if (! isset($product['id'])) {
            throw new Exception('id is required');
        }

        if (! $this->has($product['id'])) {
            throw new Exception('There is no item in shopping cart with id: ' . $product['id']);
        }

        $item = array_merge((array) $this->get($product['id']), $product);

        $items = $this->collection->insert($item);

        $this->session->set($this->getCart(), $items);

        return $this->collection->make($items);
    }

    /**
     * Update quantity of an Item.
     *
     * @param mixed $id
     * @param int $quantity
     *
     * @return \Anam\Phpcart\Collection
     */
    public function updateQty($id, $quantity)
    {
        $item = (array) $this->get($id);

        $item['quantity'] = $quantity;

        return $this->update($item);
    }


    /**
     * Update price of an Item.
     *
     * @param mixed $id
     * @param float $price
     *
     * @return \Anam\Phpcart\Collection
     */
    public function updatePrice($id, $price)
    {
        $item = (array) $this->get($id);

        $item['price'] = $price;

        return $this->update($item);
    }

    /**
     * Remove an item from the cart.
     *
     * @param  mixed $id
     * @return \Anam\Phpcart\Collection
     */
    public function remove($id)
    {
        $items = $this->session->get($this->getCart(), []);

        unset($items[$id]);

        $this->session->set($this->getCart(), $items);

        return $this->collection->make($items);
    }

    /**
     * Helper wrapper for cart items.
     *
     * @return \Anam\Phpcart\Collection
     */
    public function items()
    {
        return $this->getItems();
    }

    /**
     * Get all the items.
     *
     * @return \Anam\Phpcart\Collection
     */
    public function getItems()
    {
        return $this->collection->make($this->session->get($this->getCart()));
    }

    /**
     * Get a single item.
     * @param  $id
     *
     * @return Array
     */
    public function get($id)
    {
        $this->collection->setItems($this->session->get($this->getCart(), []));

        return $this->collection->findItem($id);
    }

    /**
     * Check an item exist or not.
     * @param  $id
     *
     * @return boolean
     */
    public function has($id)
    {
        $this->collection->setItems($this->session->get($this->getCart(), []));

        return $this->collection->findItem($id)? true : false;
    }

    /**
     * Get the number of Unique items in the cart
     *
     * @return int
     */

    public function count()
    {
        $items = $this->getItems();
        return $items->count();
    }

    /**
     * Get the total amount
     *
     * @return float
     */

    public function getTotal()
    {
        $items = $this->getItems();

        return $items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Get the total quantities of items in the cart
     *
     * @return int
     */

    public function totalQuantity()
    {
        $items = $this->getItems();

        return $items->sum(function($item) {
            return $item->quantity;
        });
    }

    /**
     * Clone a cart to another
     * 
     * @param  mix $cart
     * 
     * @return void
     */

    public function copy($cart)
    {
        if (is_object($cart)) {
            if (! $cart instanceof \Anam\Phpcart\Cart) {
                throw new InvalidArgumentException("Argument must be an instance of " . get_class($this));
            }

            $items = $this->session->get($cart->getCart(), []);
        } else {
            if (! $this->session->has($cart . self::CARTSUFFIX)) {
                throw new Exception('Cart does not exist: ' . $cart);
            }

            $items = $this->session->get($cart . self::CARTSUFFIX, []);
        }

        $this->session->set($this->getCart(), $items);

    }

    /**
     * Alias of clear (Deprecated)
     *
     * @return void
     */

    public function flash()
    {
        $this->clear();
    }

    /**
     * Empty cart
     *
     * @return void
     */

    public function clear()
    {
        $this->session->remove($this->getCart());
    }
}