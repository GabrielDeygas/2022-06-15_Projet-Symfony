<?php

namespace App\Form;

use App\Entity\Client;
use App\Form\AdressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label'     => 'Votre prénom',
                'attr'      => ['class' => 'col-sm-6']])
            ->add('lastName', null, [
                'label'     => 'Votre nom',
                'attr'      => ['class' => 'col-sm-6']])
            ->add('addresse', AdressType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class
        ]);
    }
}
