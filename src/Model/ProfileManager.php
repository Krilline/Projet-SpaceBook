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

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectUserProfile(): array
    {
        return $this->pdo->query(" SELECT firstname, lastname, pseudo,
  date_of_birth, planet_name, galaxy_name, password, email, role, avatar  FROM " . self::TABLE . "
        JOIN role ON role.id=user.role_id 
        JOIN planet ON planet.id=user.planet_id 
        JOIN galaxy on galaxy.id=planet.galaxy_id ")->fetch();
    }
}
