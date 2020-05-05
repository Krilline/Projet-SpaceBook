<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

class PostManager extends AbstractManager
{
    const TABLE = 'post';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectUserPosts($user_id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE .
            " WHERE user_id = :user_id 
            ORDER BY id DESC");
        $statement->bindValue('user_id', $user_id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
