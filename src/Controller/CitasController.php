<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CitasController extends AbstractController
{
    #[Route('/citas', name: 'citas')]
    public function index(): Response
    {
        return $this->render('default.html.twig');
    }
}
