<?php

namespace App\Form;

use App\Entity\Adresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', null, [
                'label'     => 'Rue',
                'attr'      => ['class' => 'col-sm-6']
            ])
            ->add('city', null, [
                'label'     => 'Ville',
                'attr'      => ['class' => 'col-sm-6']
            ])
            ->add('postal_code', null, [
                'label'     => 'Code postal',
                'attr'      => ['class' => 'col-sm-6']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
        ]);
    }
}
