<?php

namespace App\Controller;

use App\Entity\Especialidad;
use App\Repository\EspecialidadRepository;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CuadroMedicoController extends AbstractController
{
    #[Route('/cuadrome', name: 'cuadrome')]
    public function index(EspecialidadRepository $especialidadRepository): Response
    {
        $especialidades = $especialidadRepository->findAll();
        return $this->render('cuadromedico/cuadromedico.html.twig', [
            'especialidades' => $especialidades,
        ]);
    }

    #[Route('/cuadrome/especialidad/{id}', name: 'cuadro_especialidad')]
    public function show(Especialidad $especialidad): Response
    {
        return $this->render('cuadromedico/cuadromedico.html.twig', [
            'especialidades' => [$especialidad],
            'medicos' => $especialidad->getMedicos(),
        ]);
    }
}
