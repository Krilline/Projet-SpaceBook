<?php


namespace App\Controller;

use App\Model\ProfileManager;

class ProfileController extends AbstractController
{
    public function profile()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return $this->twig->render('Profile/profile.html.twig');
        }
    }
}
