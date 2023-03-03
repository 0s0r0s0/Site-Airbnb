<?php


namespace Rbnb\Database\Model;


use Rbnb\System\Model;

class Rooms extends Model
{
    public $city;
    public $country;
    public $price;
    public $type_id;
    public $size;
    public $description;
    public $beds;
    public $rooms_owner;


    public function toArray(): array
    {
        return [
            
            'id' => $this->id,
            'city' => $this->city,
            'country' => $this->country,
            'price' => $this->price,
            'type_id' => $this->type_id,
            'size' => $this->size,
            'description' => $this->description,
            'beds' => $this->beds,
            'rooms_owner' => $this->rooms_owner
        ];
    }
}