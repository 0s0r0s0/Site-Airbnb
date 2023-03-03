<?php


namespace Rbnb\Database\Repository;

use Rbnb\System\Database\Database;

class RepositoryManager
{
    private static $manager = null;

    private $equipementsRepository = null;
    public function equipementsRepository(): EquipementsRepository { return $this->equipementsRepository; }

    private $reservationRepository = null;
    public function reservationRepository(): ReservationRepository { return $this->reservationRepository; }

    private $rolesRepository = null;
    public function rolesRepository(): RolesRepository { return $this->rolesRepository; }

    private $roomsRepository = null;
    public function roomsRepository(): RoomsRepository { return $this->roomsRepository; }

    private $typeOfRoomRepository = null;
    public function typeOfRoomRepository(): TypeOfRoomRepository { return $this->typeOfRoomRepository; }

    private $usersRepository = null;
    public function usersRepository(): UsersRepository { return $this->usersRepository; }

    public static function manager(): ?self
    {
        if( is_null( self::$manager ) )
            self::$manager = new self();

        return self::$manager;
    }

    private function __construct() {
        $pdo = Database::connection();

        $this->equipementsRepository = new EquipementsRepository( $pdo );
        $this->reservationRepository = new ReservationRepository( $pdo );
        $this->rolesRepository = new RolesRepository( $pdo );
        $this->roomsRepository = new RoomsRepository( $pdo );
        $this->typeOfRoomRepository = new TypeOfRoomRepository( $pdo );
        $this->usersRepository = new UsersRepository( $pdo );


    }

    private function __clone() {}
    private function __wakeup() {}


}