<?php
namespace Anam\Phpcart;

use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
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

        $this->session->start();

        if ($name) {
            $this->setCart($name);
        }
    }

    public function setCart($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Cart name can not be empty.');
        }

        $this->name = $name . '_cart';
    }

    public function getCart()
    {
        return $this->name;
    }

    /**
     * Set the current cart name
     *
     * @param  string  $instance  Cart instance name
     * @return StudentVIP\Cart
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
        $this->collection->setItems($this->session->get($this->getCart(), []));

        $items = $this->collection->insert($product);

        $this->session->set($this->getCart(), $items);

        return $this->collection->make($items);
    }

    /**
     * Alias of add().
     *
     * @param  Array  $product
     * @return \Anam\Phpcart\Collection
     */
    public function update(Array $product)
    {
        return $this->add($product);
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
     * @param  int $id
     * @return $this
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
     * Flash cart data.
     *
     * @return void
     */

    public function flash()
    {
        $this->session->remove($this->getCart());
    }
}