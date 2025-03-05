<?php

// src/Controller/MovilController.php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;



// tipos form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

// clase
use App\Entity\Demandante;
use App\Entity\Bolsa;

use App\Validator\Dni;
use App\Validator\TelefonoMovil;


class BolsaController extends AbstractController
{   
  
    #[Route("/bolsa", name:"bolsa")]
    public function bolsa( EntityManagerInterface $entityManager,Request $request )
    {
       
		$form = $this->createFormBuilder();
        $form->add('dni', TextType::class, ['constraints' => [new Dni()]]);
        $form->add('nombre', TextType::class);
        $form->add('apellidos', TextType::class);
        $form->add('movil', TextType::class, ['constraints' => [new TelefonoMovil()]]);
        $form->add('bolsa', EntityType::class, [
            'class' => Bolsa::class,
            'choice_label' => 'nombre', // Usar la propiedad 'nombre' como choice_label
                ]);
        $form->add('Save', SubmitType::class);
		$form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demandante = new Demandante();
			$data = $form->getData();
			$demandante->setNombre( $data[ 'nombre']);
            $demandante->setApellidos( $data[ 'apellidos']);
            $demandante->setDni( $data[ 'dni']);
            $demandante->setMovil( $data[ 'movil']);
            $demandante->setBolsa( $data[ 'bolsa']);
			$entityManager->persist($demandante);
            $entityManager->flush(); 
          
            return $this->render('Bolsa/bolsa.html.twig');
        }
        else
            return $this->render('form.html.twig', array('form' => $form->createView(),));
    }
     
}