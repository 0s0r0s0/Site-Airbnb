<?php


namespace Rbnb\Http\Middleware;

use Closure;

use Rbnb\Rbnb;
use Rbnb\System\Session\Session;
use Rbnb\Database\Model\Roles;
use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class RenterMiddleware implements Middleware
{
    public function handle( ServerRequestInterface $request, Closure $next )
    {
        $session_user = Session::get( Session::USER );

        if( (int) $session_user->role_id === Roles::RENTER )
            return $next( $request );

        $router = Rbnb::app()->getRouter();

        return new RedirectResponse( $router->url( 'home' ) );
    }

}