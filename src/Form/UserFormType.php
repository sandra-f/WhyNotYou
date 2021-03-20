<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder      
        ->add('Ecolo', ChoiceType::class, [
            'choices' => ['Ecolo' => true,' que la planète brûle' => false,],
            'expanded'=>true,
            'label' => 'tu es plutot',
        ])

        ->add('Vegan', ChoiceType::class, [
            'choices' => ['Oui' => true,'Non' => false,],
            'expanded'=>true,
            'label' => 'Vegan',
        ])
     
        ->add('Econome', ChoiceType::class, [
            'choices' => ['oui' => true,'non' => false,],
            'expanded'=>true,
            'label' => 'Dépensier(ère) ',
        ])

        ->add('Fetard', ChoiceType::class, [
            'choices' => ['au chaud sous la couette' => true,'à chauffer la piste' => false,],
            'expanded'=>true,
            'label' => 'tes soirées sont plutôt ',
        ])

       
        ->add('Valider mon profil', SubmitType::class, ['attr' => ['class' => 'save'],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            "allow_extra_fields" => true
        ]);
    }
}