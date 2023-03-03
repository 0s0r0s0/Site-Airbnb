<?php


namespace Rbnb\System;


abstract class Model
{
    public $id;

    public function __construct( array $data = [] )
    {
        $this->hydrate( $data );
    }

    private function hydrate( array $data ): void
    {
        foreach( $data as $column => $value ) {
            if( ! property_exists( $this, $column ) )
                continue;

            $this->$column = $value;
        }
    }

}