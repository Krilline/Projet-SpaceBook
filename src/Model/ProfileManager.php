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

    public function updateProfile(array $profile)
    {
        $statement = $this->pdo->prepare("UPDATE" . self::TABLE .
            "SET 'firstname' = :firstname, 'lastname' = :lastname, 'pseudo' = :pseudo, 'date_of_birth' = :date_of_birth, 
            'galaxy_name' = :galaxy_name, 'email' = :email, 'planet_name' = :planet_name, 'password' = :password");
        $statement->bindValue('firstname', $profile['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $profile['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('pseudo', $profile['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('date_of_birth', $profile['date_of_birth'], \PDO::PARAM_STR);
        $statement->bindValue('galaxy_name', $profile['galaxy_name'], \PDO::PARAM_STR);
        $statement->bindValue('email', $profile['email'], \PDO::PARAM_STR);
        $statement->bindValue('planet_name', $profile['planet_name'], \PDO::PARAM_STR);
        $statement->bindValue('password', $profile['password'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
