<?php


namespace App\Controller;

use App\Model\ProfileManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        $profileManager = new ProfileManager();
        $profile = $profileManager->selectUserProfile();
        return $this->twig->render('Profile/profile.html.twig', ['profile' => $profile]);
    }

    public function edit()
    {
        $profileManager = new ProfileManager();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $profile['firstname'] = $_POST['firstname'];
            $profile['lastname'] = $_POST['lastname'];
            $profile['pseudo'] = $_POST['pseudo'];
            $profile['date_of_birth'] = $_POST['date_of_birth'];
            $profile['planet_name'] = $_POST['planet_name'];
            $profile['galaxy_name'] = $_POST['galaxy_name'];
            $profile['password'] = $_POST['password'];
            $profile['email'] = $_POST['email'];
            $profileManager->updateProfile($profile);
        }
        return $this->twig->render('Profile/edit.html.twig', ['profile' => $profile]);
    }
}
