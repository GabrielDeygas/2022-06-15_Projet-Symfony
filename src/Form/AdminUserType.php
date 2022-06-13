<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_user', HiddenType::class, [
                'data'          => "ROLE_USER"
            ])
            ->add('mail', null, [
                'label'         => 'Email'
            ])
            ->add('first_name', null, [
                'label'         => 'Prénom'
            ])
            ->add('lastName', null, [
                'label'         => 'Prénom'])
            ->add('password', null, [
                'label'         => 'Mot de passe'
            ])
            ->add('idAdresses', AdressType::class, [
                'label'         => "Données d'adresse"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
