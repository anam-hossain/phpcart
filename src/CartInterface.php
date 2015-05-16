<?php
namespace Anam\Phpcart;

interface CartInterface
{
	public function setCart($name);

	public function getCart();

	public function add(Array $product);

	public function update(Array $product);

	public function remove($id);

	public function getItems();

	public function get($id);

	public function has($id);

	public function clear();

	public function totalQuantity();

	public function getTotal();
}