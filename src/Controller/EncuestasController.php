<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Encuesta;
use App\Entity\Pregunta;
use App\Entity\Respuesta;
use App\Entity\Resultado;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EncuestasController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/encuestas', name: 'encuestas')]
    public function index(): Response
    {
        $encuestas = $this->entityManager->getRepository(Encuesta::class)->findAll();
        return $this->render('encuestas/encuestas.html.twig', ['encuestas' => $encuestas]);
    }

    #[Route('/encuestas/{id}', name: 'encuesta')]
    public function encuesta(Request $request, $id)
    {
        $encuesta = $this->entityManager->getRepository(Encuesta::class)->find($id);

        if (!$encuesta)
        {
            throw $this->createNotFoundException('Encuesta no encontrada');
        }

        $builder = $this->createFormBuilder();

        foreach($encuesta->getPreguntas() as $pregunta)
        {
            $respuestas = [];
            foreach($pregunta->getRespuestas() as $respuesta)
            {
                $respuestas[$respuesta->getRespuesta()] = $respuesta->getId();
            }

            $builder->add(
                'pregunta'. $pregunta->getId(),
                ChoiceType::class,
                [
                    'choices' => $respuestas,
                    'label' => $pregunta->getPregunta(),
                    'expanded' => true,
                    'multiple' => false,
                ]
            );
        }

        $builder->add('enviar', SubmitType::class);

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            
            foreach($data as $key => $value)
            {
                if (strpos($key,'pregunta') !== false)
                {
                    $respuesta = $this->entityManager->getRepository(Respuesta::class)->find($value);

                    $resultado = new Resultado();
                    $resultado->setRespuesta($respuesta);
                    $this->entityManager->persist($resultado);
                }
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('encuesta_gracias');
        }

        return $this->render('encuestas/encuestaForm.html.twig', ['form' => $form->createView(), 'encuesta' => $encuesta]);
    }

    #[Route('/encuesta/gracias', name: 'encuesta_gracias')]
    public function gracias(): Response
    {
        return $this->render('encuestas/gracias.html.twig');
    }
}