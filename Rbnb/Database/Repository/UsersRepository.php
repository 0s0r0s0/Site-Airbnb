<?php


namespace Rbnb\Database\Repository;


use Rbnb\Database\Model\Users;
use Rbnb\System\Http\Auth;
use Rbnb\System\Repository;
class UsersRepository extends Repository
{
    protected function table(): string { return 'users'; }

    public function getByEmail( string $email ): ?Users
    {
        $query = 'SELECT * FROM ' . $this->table() . ' WHERE email=:email';

        $stmt = $this->read( $query, [ 'email' => $email ] );

        if( is_null( $stmt ) ) return null;

        $user_data = $stmt->fetch();

        return $user_data ? new Users( $user_data ) : null;
    }

    public function insert( Users $data ): bool
    {
        $query = 'INSERT INTO ' . $this->table() .
            ' SET role_id=:role_id, email=:email,  password=:password, username=:username;';

        $args = [
            'role_id' => $data->role_id,
            'email' => $data->email,
            'password' => Auth::hashData($data->password),
            'username' => $data->username
        ];

        $id = $this->create( $query, $args);

        return $id > 0;
    }
}
