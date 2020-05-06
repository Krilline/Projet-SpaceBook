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

    public function selectUserProfile($user): array
    {
        $statement= $this->pdo->prepare(" SELECT user.id, firstname, lastname, pseudo,
  date_of_birth, planet_name, planet_id, galaxy_id, galaxy_name, password, 
        email, role, avatar, description  FROM " . self::TABLE . "
        JOIN role ON role.id=user.role_id 
        JOIN planet ON planet.id=user.planet_id 
        JOIN galaxy on galaxy.id=planet.galaxy_id WHERE
        email = :email AND password = :password");

        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetch();
    }

    public function updateProfile(array $profile): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET `firstname` = :firstname, `lastname` = :lastname, `pseudo` = :pseudo, 
            `date_of_birth` = :date_of_birth, 
            `email` = :email, `planet_id` = :planet_id, `password` = :password,
            `avatar` = :avatar, `description` = :description
            WHERE email = :useremail AND password = :userpassword");
        $statement->bindValue('firstname', $profile['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $profile['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('pseudo', $profile['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('date_of_birth', $profile['date_of_birth'], \PDO::PARAM_STR);
        $statement->bindValue('email', $profile['email'], \PDO::PARAM_STR);
        $statement->bindValue('planet_id', $profile['planet_id'], \PDO::PARAM_INT);
        $statement->bindValue('password', $profile['password'], \PDO::PARAM_STR);
        $statement->bindValue('avatar', $profile['avatar'], \PDO::PARAM_STR);
        $statement->bindValue('description', $profile['description'], \PDO::PARAM_STR);
        $statement->bindValue('useremail', $profile['useremail'], \PDO::PARAM_STR);
        $statement->bindValue('userpassword', $profile['userpassword'], \PDO::PARAM_STR);

        return $statement->execute();
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

    public function checkUserProfile($user)
    {
        $statement = $this->pdo->prepare("SELECT email, password FROM 
        " . self::TABLE . " WHERE email = :email");

        $statement->bindvalue('email', $user['email'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            $result = $statement->fetch();
            if ($result === false) {
                return false;// UTILISATEUR INCONNU
            } else {
                if ($result['password'] === $user['password']) {
                    return true;
                } else {
                    return false; //MOT DE PASSE MAUVAIS
                }
            }
        }
    }
}
