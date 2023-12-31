<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Support;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description',options:[
                'attr' => [
                    'rows' => 10
                    ]
            ])
            ->add('releaseDate', options:[ 
                'years'=>range(1972,date('Y')+2)
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
            ])
            ->add('support', EntityType::class,[
                'class' => Support::class,
                'choice_label'=>'name',
                'multiple' => true,
                'expanded' => true,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}