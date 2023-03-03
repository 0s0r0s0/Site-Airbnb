<?php


namespace Rbnb\TwigExtension;


use Rbnb\System\Settings;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ArrayUtils extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction( 'arrayIsEmpty', [ $this, 'arrayIsEmpty' ] )
        ];
    }

    public function arrayIsEmpty( array $arg ): bool
    {
        return empty($arg);
    }

}