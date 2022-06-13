<?php

namespace App\Form;

use App\Entity\Bookings;
use App\Entity\Lodging;
use App\Entity\Client;
use App\Entity\Adresses;
use App\Form\ClientType;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = '2022-05-05';
        $date = DateTime::createFromFormat('Y-m-d' , $date);
        $builder
            ->add('client', ClientType::class, [
                'label'         => "Renseignez vos informations"
            ] )

            ->add('nb_adults', null, [
                'label'         => "Nombre d'adultes"
            ] )
            ->add('nb_children', null,[
                'label'         => "Nombre d'enfants"
            ] )
            ->add('date_arrival', DateType::class, [
                'label'         => "Date d'arrivée",
                'widget'        => "single_text",
                'format'        => "yyyy-MM-dd",
                'data'          => new \DateTime(),
                'attr'          => ["class" => "form-control"]
            ] )
            ->add('date_departure', DateType::class, [
                'label'         => "Date de départ",
                'widget'        => "single_text",
                'format'        => "yyyy-MM-dd",
                'data'          => new \DateTime(),
                'attr'          => ["class" => "form-control"]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'    => Bookings::class,
        ]);
    }
}
