<?php

namespace App\Controller;

use App\Repository\FooterRepository;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FooterController extends AbstractController
{
    private $footerRepository;

    public function __construct(FooterRepository $footerRepository)
    {
        $this->footerRepository = $footerRepository;
    }

    #[Route('/footer', name: 'footer')]
    public function footer(): Response
    {
        $footers = $this->footerRepository->findAll();
        return $this->render('footer/footer.html.twig', ['footers' => $footers]);
    }
}
