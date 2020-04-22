<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\GalaxyManager;
use App\Model\PlanetManager;
use App\Model\ProfileManager;

class HomeController extends AbstractController
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
        return $this->twig->render('Home/index.html.twig');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Location:/profile/index');
        }
        return $this->twig->render('Home/login.html.twig');
    }

    public function signUp()
    {
        $galaxyManager = new GalaxyManager();
        $galaxys = $galaxyManager->selectUserGalaxy();
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectUserPlanet();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profileManager = new ProfileManager();
            $profile = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'pseudo' => $_POST['pseudo'],
                'date_of_birth' => $_POST['date_of_birth'],
                'planet_id' => $_POST['planet_id'],
                'password' => $_POST['password'],
                'email' => $_POST['email']
            ];
            $profileManager->createUserProfile($profile);
            header('Location:/');
        }
        return $this->twig->render('Home/sign_up.html.twig', [
            'galaxys' => $galaxys,
            'planets' => $planets
        ]);
    }
}
