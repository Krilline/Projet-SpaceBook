<?php

namespace App\Controller;

use App\Model\PostManager;
use App\Model\ProfileManager;

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
        $userId = $_SESSION['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post['title'] = $_POST['title'];
            $post['content'] = $_POST['content'];
            $post['img'] = $_POST['img'];
            $postManager->updatePost($post);
            header('Location:/post/showPosts/' . $userId);
        }
        return $this->twig->render('Posts/editpost.html.twig', ['post' => $post, 'session' => $_SESSION]);
    }

    public function addPost()
    {
        $userId = $_SESSION['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postManager = new PostManager();
            $post = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'img' => $_POST['img'],
                'user_id' => $userId,
                'score' => 0
            ];
            $postManager->insert($post);
            header('Location:/post/showPosts/' . $userId);
        }
        return $this->twig->render('Posts/addPost.html.twig', ['session' => $_SESSION]);
    }

    public function deletePost(int $id)
    {
        $userId = $_SESSION['id'];
        $postManager = new PostManager();
        $postManager->delete($id);
        header('Location:/post/showPosts/' . $userId);
    }
}
