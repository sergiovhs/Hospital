<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MenuController extends AbstractController
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    #[Route('/menu', name: 'menu')]
    public function menu(): Response
    {
        $menus = $this->menuRepository->findAll();
        return $this->render('menu/menu.html.twig', ['menus' => $menus]);
    }
}
