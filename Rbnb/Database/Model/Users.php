<?php


namespace Rbnb\Database\Model;



use Rbnb\Database\Model\Roles;
use Rbnb\Database\Repository\RepositoryManager;
use Rbnb\System\Database\Model;

class Users extends Model
{
    // Colonnes en BDD
    public $role_id;
    public $email;
    public $password;
    public $username;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'password' => $this->password,
            'username' => $this->username
        ];
    }

}
