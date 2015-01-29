<?php
namespace Anam\Phpcart;

use Symfony\Component\HttpFoundation\Session\Session;

class Cart 
{
	protected $session;

	public function __construct(Session $session)
	{
		$this->session = $session;
		$this->session->start();
	}

	public function store()
	{
		$this->session->set('test', ['yes' => "Working", 'test' => 'xyz']);
	}


	public function get()
	{
		return $this->session->get('test', 'Nothing found under the key test');
	}
}

