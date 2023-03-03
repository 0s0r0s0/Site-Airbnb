<?php

namespace Rbnb\System\Http;

use Rbnb\Rbnb;

abstract class Controller
{
	protected $twig = null;

	public function __construct()
	{
		$this->twig = Rbnb::app()->getTwig();
	}
}