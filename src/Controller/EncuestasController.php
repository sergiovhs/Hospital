<?php

namespace App\Controller;

use App\Entity\Encuestas;
use App\Entity\Respuestas;
use App\Entity\Resultados;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        $encuestas = $this->entityManager->getRepository(Encuestas::class)->findAll();
       
        return $this->render('encuesta/encuestas.html.twig', ['encuestas' => $encuestas]);
    }

    #[Route("/encuesta/{id}", name:"encuesta")]
    public function encuesta(Request $request, $id): Response
    {
        $encuesta = $this->entityManager->getRepository(Encuestas::class)->find($id);
        
        if (!$encuesta) {
            throw $this->createNotFoundException('Encuesta no encontrada');
        }

        $builder = $this->createFormBuilder();
       
        foreach ($encuesta->getPreguntas() as $pregunta) {
            $respuestas = [];
            foreach ($pregunta->getRespuestas() as $respuesta) {
                $respuestas[$respuesta->getNombre()] = $respuesta->getId();
            }
            
            $builder->add("pregunta" . $pregunta->getId(), ChoiceType::class, [
                'choices' => $respuestas,
                'label' => $pregunta->getNombre(),
                'expanded' => true
            ]);        
        }
    
        $builder->add('Send', SubmitType::class);
        $form = $builder->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            foreach ($data as $key => $value) {
                if (strpos($key, "pregunta") !== false) {
                    $respuesta = $this->entityManager->getRepository(Respuestas::class)->find($value);            
                    $resultado = new Resultados();
                    
                    $resultado->setRespuesta($respuesta);
                    
                    $this->entityManager->persist($resultado);
                }
            }
            $this->entityManager->flush();
            
            return $this->render('encuesta/gracias.html.twig');
        } else {
            return $this->render('encuesta/encuesta_form.html.twig', ['form' => $form->createView()]);
        }
    }
}
