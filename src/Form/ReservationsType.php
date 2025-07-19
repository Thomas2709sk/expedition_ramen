<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom']),
                    new Length(['min' => 2, 'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères']),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre adresse email']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide']),
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^0[1-9](\d{8})$/',
                        'message' => 'Veuillez entrer un numéro de téléphone valide (ex : 0612345678)',
                    ]),
                ],
            ])
            ->add('commentary', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'constraints' => [
                    new Length(['max' => 500, 'maxMessage' => 'Le commentaire ne doit pas dépasser {{ limit }} caractères']),
                ],
            ])
            ->add('day', DateType::class, [
        'label' => 'Jour de la réservation',
        'widget' => 'single_text',
        'required' => true,
    ])
            ->add('people', ChoiceType::class, [
                'label' => 'Nombre de personnes',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('time', TimeType::class, [
                'label' => 'Créneau horaire',
                'input' => 'datetime',
                'widget' => 'choice',
                'hours' => [11, 12, 13, 18, 19, 20],
                'minutes' => [0, 30],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
