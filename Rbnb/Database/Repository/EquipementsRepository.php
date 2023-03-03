<?php


namespace Rbnb\Database\Repository;

use Rbnb\Database\Model\Equipements;
use Rbnb\System\Database\Repository;

class EquipementsRepository extends Repository
{
    protected function table(): string { return 'equipements_type'; }

    public function findAll(): array
    {
        $query = 'SELECT * FROM '.$this->table();

        $stmt = $this->read( $query );

        if( is_null( $stmt ) )
            return [];

        $equipements = [];

        while( $equipement = $stmt->fetch() )
        {
            $equipements[] = new Equipements( $equipement );
        }

        return $equipements;
    }

    public function findByRoomsId( int $rooms_id ): array
    {
        $equipements_rooms = 'equipements_rooms';

        $query = sprintf(
            'SELECT eqt.*
						FROM %s as eqt 
						JOIN %s as eqr ON eqr.equipements_id=eqt.id
					WHERE eqr.rooms_id=:rooms_id
					ORDER BY eqt.label',
            $this->table(),
            $equipements_rooms
        );

        $stmt = $this->read( $query, [ 'rooms_id' => $rooms_id ] );

        if( is_null( $stmt ) ) { return []; }

        $equipements = [];

        while( $equipements_data = $stmt->fetch() )
        {
            $equipements[] = new Equipements( $equipements_data );
        }

        return $equipements;
    }

    public function bind( int $rooms_id, array $equipements_id ): bool
    {
        $equipements = [];


        foreach( $equipements_id as $equipements_ids ) {
            $equipements[] = sprintf( '(%s,%s)', $rooms_id, $equipements_ids );
        }

        $query = sprintf( 'INSERT INTO equipements_rooms (rooms_id, equipements_id) VALUES %s', implode(',', $equipements ) );

        $id = $this->create( $query );

        return $id > 0;

    }
}
