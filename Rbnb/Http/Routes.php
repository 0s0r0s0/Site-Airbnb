<?php

namespace Rbnb\Http;

use Closure;

use MiladRahimi\PhpRouter\Router;

abstract class Routes
{
    public static function visitor(): Closure
    {
        return function( Router $router )
        {
            $router
                ->name( 'home' )
                ->get( '/', 'PageController@index' )

                ->name( 'login' )
                ->get( '/connexion', 'AuthController@index' )

                ->name( 'auth' )
                ->post( '/auth', 'AuthController@auth', [] )

                ->name('register')
                ->get('/inscription', 'RegisterController@index')

                ->name('auth_register')
                ->post('/inscription', 'RegisterController@insert')
            ;
        };
    }

    public static function renter(): Closure
    {
        return function( Router $router )
        {
            $router
               
                ->name('locations')
                ->get('/locations', 'RoomsController@index')

                ->name('reservation_location')
                ->get('/locations-reservation', 'RoomsController@show')

                ->name( 'ajout_location' )
                ->get( '/locations-ajout', 'RoomsController@add' )

                ->name( 'ajout_location_insert' )
                ->post( '/locations-ajout-insert', 'RoomsController@insert' )

            ;
        };
    }

    public static function user(): Closure
    {
        return function( Router $router )
        {
            $router
                ->name('annonces')
                ->get('/annonces', 'AnnoncesController@index')

                ->name('annonce')
                ->get('/annonce/{id}', 'AnnoncesController@show')

                ->name('reservation')
                ->post('/reservation/{id}', 'AnnoncesController@book')
                
                ->name('mes_reservations')
                ->get('/mes-reservations/{id}', 'AnnoncesController@booked')
            ;
        };
    }

    public static function auth(): Closure {
        return function ( Router $router ) {
            $router
                ->name('logout')
                ->get('/logout', 'AuthController@logout')
            ;
        };
    }
}