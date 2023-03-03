<?php


namespace Rbnb\TwigExtension;


use Rbnb\Rbnb;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class URLUtils extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction( 'asset', [ $this, 'getAssetsUrl' ] ),
            new TwigFunction( 'route', [ $this, 'getRouteUrl' ] )
        ];
    }

    public function getAssetsUrl( $value ): string
    {
        return sprintf(
            '%s://%s/assets/%s',
            $_SERVER[ 'REQUEST_SCHEME' ],
            $_SERVER[ 'HTTP_HOST' ],
            $value
        );
    }

    public function getRouteUrl( string $name, array $params = [] ): string
    {
        $router = Rbnb::app()->getRouter();

        return $router->url( $name, $params );
    }
}