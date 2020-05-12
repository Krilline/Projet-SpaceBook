<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\CommentManager;

class PostController extends AbstractController
{
    public function showPosts($id)
    {
        $postManager = new PostManager();
        $posts = $postManager->selectUserPosts($id);
        return $this->twig->render('Posts/posts.html.twig', ['posts' => $posts, 'session' => $_SESSION]);
    }

    public function editPost($id)
    {
        $postManager = new PostManager();
        $post = $postManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post['title'] = $_POST['title'];
            $post['content'] = $_POST['content'];
            $post['img'] = $_POST['img'];
            $postManager->updatePost($post);
            header("Location:/profile/index");
        }
        return $this->twig->render('Posts/editpost.html.twig', ['post' => $post, 'session' => $_SESSION]);
    }

    public function showComments($id)
    {
        $commentManager = new CommentManager();
        $comments = $commentManager->selectComments($id);
        //var_dump($comments); die;
        return $this->twig->render('Posts/comments.html.twig', ['comments' => $comments, 'session' => $_SESSION]);
    }
}
