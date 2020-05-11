<?php


namespace App\Controller;

use App\Model\ContactManager;
use App\Model\PostManager;
use App\Model\ProfileManager;

class AdminController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Admin/index.html.twig');
    }

    public function posts()
    {
        $postManager = new PostManager();
        $posts = $postManager->selectAll();
        return $this->twig->render('Admin/posts.html.twig', ['posts' => $posts]);
    }

    public function users()
    {
        $profileManager = new ProfileManager();
        $profiles = $profileManager->selectAll();
        return $this->twig->render('Admin/users.html.twig', ['profiles' => $profiles]);
    }

    public function support()
    {
        $contactManager = new ContactManager();
        $messages = $contactManager->selectAll();
        return $this->twig->render('Admin/support.html.twig', ['messages' => $messages]);
    }

    public function deleteMessage($id)
    {
        $contactManager = new ContactManager();
        $contactManager->deleteMessageById($id);
        header("Location: /Admin/support");
    }

    public function deletePost($id)
    {
        $postManager = new PostManager();
        $postManager->deletePostById($id);
        header("Location: /Admin/posts");
    }

    public function deleteUser($id)
    {
        $profileManager = new ProfileManager();
        $profileManager->deleteUserProfile($id);
        header("Location: /Admin/users");
    }

    public function modifyUser()
    {
        return $this->twig->render('Admin/modify.html.twig');
    }
}
