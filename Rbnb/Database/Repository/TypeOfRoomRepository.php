<?php


namespace Rbnb\Database\Repository;

use Rbnb\System\Repository;
use Rbnb\Database\Model\TypeOfRoom;
class TypeOfRoomRepository extends Repository
{
    protected function table(): string { return 'room_type'; }

    public function findLabelById( int $id ): string
    {
        $query = 'SELECT * FROM '.$this->table().' WHERE id=:id ';

        $stmt = $this->read( $query, [ 'id' => $id ] );

        if( is_null( $stmt ) ) return '';

        $data = $stmt->fetch();

        return $data ? $data[ 'label' ] : '';
    }

    public function findAll(): array
    {
        $query = 'SELECT * FROM '.$this->table();

        $stmt = $this->read( $query );

        if( is_null( $stmt ) )
            return [];

        $room_types = [];

        while( $room_type = $stmt->fetch() )
        {
            $room_types[] = new TypeOfRoom( $room_type );
        }

        return $room_types;
    }
}