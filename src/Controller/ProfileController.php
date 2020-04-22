<?php


namespace App\Controller;

use App\Model\ProfileManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        $profileManager = new ProfileManager();
        $profile = $profileManager->selectUserProfile();
        return $this->twig->render('Profile/profile.html.twig', ["profile" => $profile]);
    }
}
