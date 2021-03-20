<?php
 namespace App\Form;

use App\Entity\Item;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Hobbies', EntityType::class, [
            'class' => Item::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('i') 
                    ->where('i.category =:cat')
                    ->setParameter('cat', 1);
#return le repo filtrer, par le Query Builder, 
#dans la liste total des i, pré selectionner la catégorie cat =>1
            },
            'choice_label' => 'name',
        ])
        
       ->add('Valeurs', EntityType::class, [
            'class' => Item::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('i') 
                    ->where('i.category =:cat')
                    ->setParameter('cat', 2);
            },
            'choice_label' => 'name',

            ])
        ->add('Valider', SubmitType::class, ['attr' => ['class' => 'save'],])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }


}
