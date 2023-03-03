<?php


namespace Rbnb\Database\Model;

use Rbnb\System\Database\Model;


class Roles extends Model
{
    public const RENTER = 2;
    public const USER = 1;

    public $label;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' =>$this->label
        ];
    }
}