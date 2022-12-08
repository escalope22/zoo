<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/", name="app_menu")
     */
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'titre' => 'index de la page',
        ]);
    }
}
