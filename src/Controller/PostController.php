<?php

namespace App\Controller;

use App\Model\PostManager;

class PostController extends AbstractController
{
    public function showPosts($id)
    {
        $postManager = new PostManager();
        $posts = $postManager->selectUserPosts($id);
        return $this->twig->render('Posts/posts.html.twig', ['posts' => $posts]);
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
        return $this->twig->render('Posts/editpost.html.twig', ['post' => $post]);
    }

}