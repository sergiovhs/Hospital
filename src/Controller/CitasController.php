<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cita;
use App\Form\CitaType;

class CitasController extends AbstractController
{
    #[Route('/citas', name: 'citas')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $citas = $entityManager->getRepository(Cita::class)->findAll();
        return $this->render('citas/index.html.twig', ['citas' => $citas]);
    }

    #[Route('/citas/nueva', name: 'nueva_cita')]
    public function nueva(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cita = new Cita();
        $form = $this->createForm(CitaType::class, $cita);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cita);
            $entityManager->flush();

            return $this->redirectToRoute('citas');
        }

        return $this->render('citas/nueva.html.twig', ['form' => $form->createView()]);
    }
}