<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Servicio;
use App\Entity\Texto;
use App\Repository\ServicioRepository;
use App\Repository\TextoRepository;


class ServiciosController extends AbstractController
{
    #[Route('/servicios', name: 'servicios')]
    public function index(ServicioRepository $serviciosrepository): Response
    {
        $servicios = $serviciosrepository->findAll();
        return $this->render('servicios/servicios.html.twig', ['servicios' => $servicios]);
    }

    #[Route('/servicios/{id}', name: 'verservicio')]
    public function show(ServicioRepository $serviciosrepository, Servicio $servicio, TextoRepository $textorepository): Response
    {
        $textos = $textorepository->findBy(['servicio' => $servicio], ['orden' => 'ASC']);
        $servicios = $serviciosrepository->findAll();
        return $this->render('servicios/servicios.html.twig', ['servicio' => $servicio, 'servicios' => $servicios, 'textos' => $textos]);
    }
}