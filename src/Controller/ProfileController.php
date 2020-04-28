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
        $profile = $profileManager->selectUserProfile();
        return $this->twig->render('Profile/profile.html.twig', ['profile' => $profile]);
    }

    public function edit(int $id)
    {
        $profileManager = new ProfileManager();
        $profile = $profileManager->selectOneById($id);

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

    public function delete(int $id)
    {
        $profileManager = new ProfileManager();
        $profile = $profileManager->selectOneById($id);
        $profileManager->deleteUserProfile($profile);
        header("Location:/home/index");
        return $this->twig->render('Profile/delete.html.twig', [
            'profile' => $profile
        ]);
    }

}
