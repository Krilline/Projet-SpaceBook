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
class FriendManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'friend';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFriend($id): array
    {
        $statement = $this->pdo->prepare("SELECT friend_id FROM " . self::TABLE . " WHERE user_id = :id");
        $statement->bindValue('id' , $id , \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

}
