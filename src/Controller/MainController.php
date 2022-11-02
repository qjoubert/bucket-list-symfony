<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/", name="main_home")
     */
    public function home() {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/about_us", name="main_about")
     */
    public function about() {
        $team = json_decode(file_get_contents('../data/team.json'));
        return $this->render('main/about.html.twig', ['team' => $team]);
    }
}