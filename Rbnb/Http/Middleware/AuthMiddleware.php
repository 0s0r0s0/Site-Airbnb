<?php

namespace Rbnb\Http\Middleware;

use Closure;

use Rbnb\Rbnb;
use Rbnb\System\Session\Session;
use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AuthMiddleware implements Middleware
{
	/**
	 * Handle request and response
	 *
	 * @param ServerRequestInterface $request
	 * @param Closure $next
	 *
	 * @return ResponseInterface|mixed|null
	 *
	 * @throws \MiladRahimi\PhpRouter\Exceptions\UndefinedRouteException
	 */
	public function handle( ServerRequestInterface $request, Closure $next )
	{
		$session_user = Session::get( Session::USER );

		if( ! is_null( $session_user ) )
			return $next( $request );

		$router = Rbnb::app()->getRouter();

		return new RedirectResponse( $router->url( 'login' ) );
	}
}

