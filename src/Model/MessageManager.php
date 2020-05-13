<?php


namespace App\Model;

class MessageManager extends AbstractManager
{


    const TABLE = 'message';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    public function insertMessage(array $message)
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(conversation_id, pseudo, content, `current_date`) 
        VALUES (1, :pseudo, :content, :current_date)");
        $statement->bindValue('pseudo', $message['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('content', $message['content'], \PDO::PARAM_STR);
        $statement->bindValue('current_date', $message['current_date'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
