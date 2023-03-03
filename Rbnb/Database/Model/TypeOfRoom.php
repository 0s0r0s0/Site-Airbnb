<?php


namespace Rbnb\Database\Model;


use Rbnb\System\Database\Model;

class TypeOfRoom extends Model
{
    public $label;


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label
        ];
    }
}
