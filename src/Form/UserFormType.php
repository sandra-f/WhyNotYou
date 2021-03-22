<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder      
        ->add('Ecolo', ChoiceType::class, [
            'choices' => ['Ecolo' => true,'Pour que la planète brûle' => false,],
            'expanded'=>true,
            'label' => '1. Tu es plutôt'
    
        ])

        ->add('Vegan', ChoiceType::class, [
            'choices' => ['Vegan' => true,'Hmm... Charaaal!' => false,],
            'expanded'=>true,
            'label' => '2.'
        ])
     
        ->add('Econome', ChoiceType::class, [
            'choices' => ['Econome' => true,'Panier percé' => false,],
            'expanded'=>true,
            'label' => '3.'
        ])

        ->add('Sportif', ChoiceType::class, [
            'choices' => ['Sportif' => true,'En jogging devant la télé' => false,],
            'expanded'=>true,
            'label' => '4.'
        ])

        ->add('Fetard', ChoiceType::class, [
            'choices' => ['A chauffer la piste' => true,'Au chaud sous la couette' => false,],
            'expanded'=>true,
            'label' => '5. Tes soirées se passent plutôt'
        ])
        ->add('Editer', SubmitType::class, ['attr' => ['class' => 'btn btn-outline-success']])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "allow_extra_fields" => true
        ]);
    }
}