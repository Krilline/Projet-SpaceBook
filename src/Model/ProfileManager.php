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

    public function createUserProfile($user)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(firstname, lastname, 
        pseudo, date_of_birth, planet_id, password, email, role_id, avatar)
                   VALUES (:firstname, :lastname, :pseudo, :date_of_birth, 
                   :planet_id, :password, :email, 2, 
                   'https://lumiere-a.akamaihd.net/v1/images/open-uri20150422-20810-s1q5sn_ecb74152.jpeg')");

        $statement->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('date_of_birth', $user['date_of_birth'], \PDO::PARAM_STR);
        $statement->bindValue('planet_id', $user['planet_id'], \PDO::PARAM_INT);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
