<?php


namespace App\Model;

class CommentManager extends AbstractManager
{
    const TABLE = 'comment';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectComments($postId): array
    {
        $statement = $this->pdo->prepare("SELECT comment.id, comment.content, comment.current_date, 
            comment.user_id, comment.post_id, post.title as post_title, post.content as post_content, 
            post.img as post_img, post.score as post_score, user.lastname as user_lastname, 
            user.firstname as user_firstname
            FROM " . self::TABLE .
            " JOIN post ON comment.post_id = post.id 
            JOIN user ON comment.user_id = user.id
            WHERE comment.post_id = :post_id 
            ORDER BY id DESC");
        $statement->bindValue('post_id', $postId, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function delete($id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
