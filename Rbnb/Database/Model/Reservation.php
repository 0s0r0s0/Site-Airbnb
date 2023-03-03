<?php


namespace Rbnb\Database\Model;

use Rbnb\System\Database\Model;
class Reservation extends model
{
    public $start_rent;
    public $end_rent;
    public $user_id;
    public $room_id;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'start_rent' => $this->start_rent,
            'end_rent' => $this->end_rent,
            'user_id' => $this->user_id,
            'room_id' => $this->room_id
        ];
    }

}