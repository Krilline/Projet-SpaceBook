<?php


namespace App\Controller;

use App\Model\ProfileManager;
use App\Model\GalaxyManager;
use App\Model\PlanetManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        $profileManager = new ProfileManager();
        $profile = [
            'email' => $_SESSION['email'],
            'password' => $_SESSION['password'],
        ];
        $profile = $profileManager->selectUserProfile($profile);
        return $this->twig->render('Profile/profile.html.twig', ['profile' => $profile]);
    }

    public function edit()
    {
        $profileManager = new ProfileManager();
        $user = [
            'email' => $_SESSION['email'],
            'password' => $_SESSION['password'],
        ];
        $profile = $profileManager->selectUserProfile($user);

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
            $profile['useremail'] = $_SESSION['email'];
            $profile['userpassword'] = $_SESSION['password'];
            $profileManager->updateProfile($profile);
            header("Location:/profile/index");
        }
        $galaxyManager = new GalaxyManager();
        $galaxys = $galaxyManager->selectUserGalaxy();
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectUserPlanet();
        return $this->twig->render('Profile/edit.html.twig', [
            'galaxys' => $galaxys,
            'planets' => $planets,
            'profile' => $profile
        ]);
    }

    public function delete()
    {
        $profileManager = new ProfileManager();
        //var_dump($_SESSION); die;
        $user = ['email' => $_SESSION['email']];
        //$user = ['id' => $_SESSION['id']];
        $profile = $profileManager->deleteUserProfile($user);
        //$profile = $profileManager->selectUserProfile($user);
        //$profileManager->deleteUserProfile($profile);
        header("Location:/home/index");
        //return $this->twig->render('Profile/delete.html.twig', ['user' => $user]);
        return $this->twig->render('Profile/delete.html.twig', ['profile' => $profile]);
    }
}
