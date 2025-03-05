<?php

namespace App\Form;

use App\Entity\Cita;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Especialidad;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CitaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('dni', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 9, 'max' => 9]),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]{8}[A-Z]$/',
                        'message' => 'El DNI debe tener 8 números seguidos de una letra mayúscula.',
                    ]),
                    new Assert\Callback([$this, 'validateDni']),
                ],
            ])
            ->add('direccion', TextType::class)
            ->add('telefono', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => '/^[0-9]{9}$/',
                        'message' => 'El teléfono debe tener 9 dígitos.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(['message' => 'El email "{{ value }}" no es un email válido.']),
                ],
            ])
            ->add('especialidad', EntityType::class, [
                'class' => Especialidad::class,
                'choice_label' => 'nombre',
            ])
            ->add('save', SubmitType::class, ['label' => 'Guardar Cita']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cita::class,
        ]);
    }

    public function validateDni($dni, ExecutionContextInterface $context)
    {
        $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $numero = substr($dni, 0, 8);
        $letra = substr($dni, -1);

        if (strlen($dni) != 9 || !is_numeric($numero) || strpos($letras, $letra) === false) {
            $context->buildViolation('El DNI no es válido.')
                ->atPath('dni')
                ->addViolation();
            return;
        }

        if ($letras[$numero % 23] != $letra) {
            $context->buildViolation('El DNI no es válido.')
                ->atPath('dni')
                ->addViolation();
        }
    }
}