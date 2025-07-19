<?php

namespace App\Form;

use App\Entity\Side;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
        'label' => 'Nom de l\'accompagnements'
    ])
    ->add('description', null, [
        'label' => 'Description'
    ])
    ->add('price', NumberType::class, [
        'label' => 'Prix (€)',
        'scale' => 2,
        'required' => true,
        'attr' => ['min' => 0],     
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Side::class,
        ]);
    }
}
