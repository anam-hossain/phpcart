<?php
namespace Anam\Phpcart;

use Symfony\Component\HttpFoundation\Session\Session;

class CartFactory
{
	public static function create($cartName = null, $cartStorageInstance = null)
	{
		if ($cartStorageInstance instanceof Session) {
			return new Cart($cartName, $cartStorageInstance, new Collection());
		}
		
		return new Cart($cartName, new Session(), new Collection());
	}
}