<?php

namespace App\Form;

use App\Entity\Lodging;
use App\Entity\User;
use App\Entity\TypeLodging;
use App\Repository\LodgingRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminLodgingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('imageFile', FileType::class, [
                'required'      =>  true,
                'label'         => 'Image du logement'
            ])
            ->add('IdTypelodging', EntityType::class, [
                'label'         => "Type de logement",
                'class'         => TypeLodging::class,
                'placeholder'   => "Choisir un type de logement",
                'choice_label'  => "type",
                'mapped'        => false,
                'expanded'      => false,
                'multiple'      => true
            ])
            ->add('IdUser', EntityType::class, [
                'label'         => "Propriétaire",
                'query_builder' => function(UserRepository $userRepo) {
                    return $userRepo->orderLabel();
                },
                'class'         => User::class,
                'placeholder'   => "Choisir un propriétaire",
                'choice_label'  => "mail",
                'mapped'        => false,
                'expanded'      => false,
                'multiple'      => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lodging::class
        ]);
    }
}
