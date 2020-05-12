<?php


namespace App\Controller;

use App\Model\ContactManager;
use App\Model\GalaxyManager;
use App\Model\PlanetManager;
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

    public function modifyUser($id)
    {
        $profileManager = new ProfileManager();
        $profile = $profileManager->selectUserProfile($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profile['firstname'] = $_POST['firstname'];
            $profile['lastname'] = $_POST['lastname'];
            $profile['pseudo'] = $_POST['pseudo'];
            $profile['date_of_birth'] = $_POST['date_of_birth'];
            $profile['planet_id'] = $_POST['planet_id'];
            $profile['password'] = $_POST['password'];
            $profile['email'] = $_POST['email'];
            $profile['avatar'] = $_POST['avatar'];
            $profile['description'] = $_POST['description'];
            $profile['id'] = $id;
            $profileManager->updateProfile($profile);
            header("Location:/Admin/users");
        }
        $galaxyManager = new GalaxyManager();
        $galaxys = $galaxyManager->selectUserGalaxy();
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectUserPlanet();
        return $this->twig->render('Admin/modify.html.twig', [
            'galaxys' => $galaxys,
            'planets' => $planets,
            'profile' => $profile
        ]);
    }
}
