<?php


namespace Rbnb\Http\Middleware;


class UserMiddleware
{
    public function handle( ServerRequestInterface $request, Closure $next )
    {
        $session_user = Session::get( Session::USER );

        $granted_roles = [
            Role::RENTER,
            Role::USER
        ];

        if( in_array( (int) $session_user->role_id, $granted_roles ) )
            return $next( $request );

        $router = Rbnb::app()->getRouter();

        return new RedirectResponse( $router->url( 'home' ) );
    }

}