<?php


namespace App\Controller;

use App\Model\ProfileManager;
use App\Model\GalaxyManager;
use App\Model\PlanetManager;
use App\Model\FriendManager;

class ProfileController extends AbstractController
{
    public function index()
    {
        if (empty($_SESSION['login']) || $_SESSION['login'] == false) {
            Header('Location:/Home/index');
        } else {
            $profileManager = new ProfileManager();
            $id = $_SESSION['id'];
            $profile = $profileManager->selectUserProfile($id);
            return $this->twig->render('Profile/profile.html.twig', [
                'profile' => $profile,
                'session' => $_SESSION
            ]);
        }
    }

    public function edit()
    {
        if (empty($_SESSION['login']) || $_SESSION['login'] == false) {
            Header('Location:/Home/index');
        } else {
            $profileManager = new ProfileManager();
            $id = $_SESSION['id'];
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
                header("Location:/profile/index");
            }
            $galaxyManager = new GalaxyManager();
            $galaxys = $galaxyManager->selectUserGalaxy();
            $planetManager = new PlanetManager();
            $planets = $planetManager->selectUserPlanet();
            return $this->twig->render('Profile/edit.html.twig', [
                'galaxys' => $galaxys,
                'planets' => $planets,
                'profile' => $profile,
                'session' => $_SESSION
            ]);
        }
    }

    public function delete($id)
    {
        $profileManager = new ProfileManager();
        $profileManager->deleteUserProfile($id);
        unset($_SESSION['login']);
        unset($_SESSION['id']);
        session_destroy();
        header("Location: /home/index");
    }

    public function showFriend($id)
    {
        $friendManager = new FriendManager();
        $profileManager = new ProfileManager();
        $friends = $friendManager->selectFriend($id);
        $result = [];

        foreach ($friends as $friend) {
            $user = $profileManager->selectOneById(intval($friend['friend_id']));
            array_push($result, $user);
        }
        //var_dump($result);
        return $this->twig->render('Profile/showFriend.html.twig', [ 'result'=> $result ]);
    }
}
