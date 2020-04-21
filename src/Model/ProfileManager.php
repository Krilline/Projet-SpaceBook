<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class ProfileManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    public function selectUserProfile(): array
    {
        return $this->pdo->query(" SELECT firstname, lastname, pseudo,
  date_of_birth, planet, password, email, role, avatar  FROM " . $this->table . "
        JOIN role ON role.id=user.role_id JOIN planet ON planet.id=user.planet_id")->fetchAll();
    }
}
