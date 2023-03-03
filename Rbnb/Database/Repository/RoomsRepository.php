<?php

namespace Rbnb\Database\Repository;

use Rbnb\Database\Model\Rooms;
use Rbnb\System\Database\Repository;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class RoomsRepository extends Repository
{
    protected function table(): string { return 'rooms'; }

    public function findAll(): array
    {
        $room_type = 'room_type';
        $users = 'users';
        $equipements_rooms = 'equipements_rooms';
        $query = sprintf( /* rooms* -> 
            SELECT rooms.*, rt.label, us.username 
            FROM rooms
            LEFT JOIN room_type AS rt ON rooms.type_id=rt.id
            LEFT JOIN users AS us ON rooms.rooms_owner=us.id */

            'SELECT rooms.*, rt.label, us.username
						FROM %s as rooms
						    LEFT JOIN %s as rt ON rooms.type_id=rt.id
						    LEFT JOIN %s as us ON rooms.rooms_owner=us.id',
            $this->table(),
            $room_type,
            $users,
        );

        $stmt = $this->read( $query );

        if( is_null( $stmt ) )
            return [];

        $rooms = [];

        while( $room_data = $stmt->fetch() )
        {
            $rooms[] = new Rooms( $room_data ); //$rooms[] = [new Rooms($room_data),new Users($room_data), etc...]
        }

        return $rooms;
        
    }

    public function insert( Rooms $rooms ): int
    {
        $query = 'INSERT INTO '.$this->table().
            ' SET city=:city, country=:country,'.
            'price=:price, type_id=:type_id,'. 
            'size=:size, description=:description,'. 
            'beds=:beds, rooms_owner=:rooms_owner';


        $id = $this->create( $query, [
            'city' => $rooms->city,
            'country' => $rooms->country,
            'price' => $rooms->price,
            'type_id' => $rooms->type_id,
            'size' => $rooms->size,
            'description' => $rooms->description,
            'beds' => $rooms->beds,
            'rooms_owner' => $rooms->rooms_owner
        ]);


        return $id;
    }

    public function findById(int $id ): ?Rooms
    {
        $query = 'SELECT * FROM ' . $this->table() . ' WHERE id=:id';

        $stmt = $this->read( $query, [ 'id' => $id ]);

        if( is_null( $stmt ) ) return null;

        $data = $stmt->fetch();

        return $data ? new Rooms( $data ) : null;
    }

    public function findByOwnerId(int $rooms_owner ): array
    {
        $query = 'SELECT * FROM ' . $this->table() . ' WHERE rooms_owner=:rooms_owner';

        $stmt = $this->read( $query, [ 'rooms_owner' => $rooms_owner ] );

        if( is_null( $stmt ) )
            return [];

        $rooms = [];

        while( $room_data = $stmt->fetch() )
        {
            $rooms[] = new Rooms( $room_data ); //$rooms[] = [new Rooms($room_data),new Users($room_data), etc...]
        }

        return $rooms;
    }



}