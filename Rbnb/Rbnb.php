<?php

namespace Rbnb;

use Rbnb\Http\Middleware\RenterMiddleware;
use Rbnb\Http\Middleware\AuthMiddleware;
use Rbnb\Http\Middleware\UserMiddleware;
use Rbnb\Http\Middleware\VisitorMiddleware;
use Rbnb\Http\Routes;
use Rbnb\System\Http\Auth;
use Rbnb\TwigExtension\ArrayUtils;
use Rbnb\TwigExtension\HTMLUtils;
use Rbnb\TwigExtension\URLUtils;

use MiladRahimi\PhpRouter\Router;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Rbnb
{
	private $auth = null;
	public function getAuth(): ?Auth { return $this->auth; }

	private $router = null;
	public function getRouter(): ?Router { return $this->router; }

	private $twig = null;
	public function getTwig(): ?Environment { return $this->twig; }

	private static $instance = null;

	public static function app(): self
	{
		if( is_null( self::$instance ) )
			self::$instance = new self();

		return self::$instance;
	}

	public function start(): void
	{
		session_start();

		$this->loadAuth();
		$this->loadTwig();
		$this->loadRouter();
	}

	private function loadAuth(): void {
		$this->auth = new Auth();
	}
// Middleware
	private function loadRouter(): void
	{
		$this->router = new Router();

		$attr_renter = [
			'namespace' => 'Rbnb\Http\Controller',
            'middleware' => [RenterMiddleware::class]
        ];

		$attr_user = [
			'namespace' => 'Rbnb\Http\Controller',
            'middleware' => [AuthMiddleware::class]
		];


		$attr_visitor = [
			'namespace' => 'Rbnb\Http\Controller',
            'middleware' => [ VisitorMiddleware::class ]
		];

		$attr_auth = [
            'namespace' => 'Rbnb\Http\Controller',
            'middleware' => [ AuthMiddleware::class ]
        ];

		$this->router
			->group( $attr_renter, Routes::renter() )
			->group( $attr_user, Routes::user() )
            ->group($attr_auth, Routes::auth())
			->group( $attr_visitor, Routes::visitor() );

		// TODO: Gérer Erreurs et 404
		$this->router->dispatch();
	}

	private function loadTwig(): void
	{
		$loader = new FilesystemLoader( [
			ROOT_PATH . 'views',
			ROOT_PATH . 'views/renter',
			ROOT_PATH . 'views/user',
			ROOT_PATH . 'views/visitor'
		]);

		$this->twig = new Environment($loader, [
			// 'cache' => ROOT_PATH . 'cache'
		]);

		$this->twig->addExtension( new URLUtils() );
		$this->twig->addExtension( new HTMLUtils() );
        $this->twig->addExtension( new ArrayUtils() );
	}

	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {}
}