<?php


namespace Rbnb\Database\Repository;

use Rbnb\System\Database\Repository;
use Rbnb\Database\Model\Reservation;
use Rbnb\System\Session\Session;


class ReservationRepository extends Repository
{

    protected function table(): string { return 'reservation'; }

    public function findByReservationId( int $rooms_owner ): array
    {
        $query = 'SELECT reservation.*, rooms.*, users.username FROM rooms'.
             ' JOIN reservation ON rooms.id=reservation.room_id'.
             ' JOIN users ON reservation.user_id=users.id'.
            ' WHERE rooms.rooms_owner=:rooms_owner ORDER BY reservation.id DESC';

        $stmt = $this->read( $query, [ 'rooms_owner' => $rooms_owner ]);

        if( is_null( $stmt ) ) return [];

        $reservations = [];

        while( $reservation = $stmt->fetch() )
        {
            $reservations[] = $reservation;
        }

        return $reservations;
        var_dump($reservations);die();
    }

    public function findByUserId( int $user_id ): array
    {
        $query = 'SELECT rooms.*, users.username, reservation.* FROM users'.
            ' JOIN reservation ON users.id=reservation.user_id'.
            ' JOIN rooms ON rooms.id=reservation.room_id'.
            ' WHERE users.id=:user_id ORDER BY reservation.id DESC';


        $stmt = $this->read( $query, [ 'user_id' => $user_id ]);

        if( is_null( $stmt ) ) return [];

        $reservations = [];

        while( $reservation = $stmt->fetch() )
        {
            $reservations[] = $reservation;
        }
        return $reservations;
    }

    public function insert( Reservation $reservation): int
    {
        $query = 'INSERT INTO '.$this->table().' SET user_id=:user_id, room_id=:room_id, start_rent=:start_rent, end_rent=:end_rent';

        $id = $this->create( $query, [
            'user_id' => (int) $reservation->user_id,
            'room_id' => (int) $reservation->room_id,
            'start_rent' => $reservation->start_rent,
            'end_rent' => $reservation->end_rent
        ]);

        return $id;
    }
}