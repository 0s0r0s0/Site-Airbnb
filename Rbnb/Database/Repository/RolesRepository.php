<?php


namespace Rbnb\Database\Repository;

use Rbnb\Database\Model\Roles;
use Rbnb\System\Database\Repository;

class RolesRepository extends Repository
{
    protected function table(): string { return 'roles'; }

    public function getById( int $id ): ?Roles
    {
        $query = 'SELECT * FROM ' . $this->table() . ' WHERE id=:id';

        $stmt = $this->read( $query, [ 'id' => $id ]);

        if( is_null( $stmt ) ) return null;

        $role_data = $stmt->fetch();

        return $role_data ? new Roles( $role_data ) : null;
    }
}
