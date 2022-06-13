<?php

namespace App\DataFixtures;

use App\Entity\Adresses;
use App\Entity\BillsContent;
use App\Entity\BillsSkeleton;
use App\Entity\Bookings;
use App\Entity\Extras;
use App\Entity\Client;
use App\Entity\ExtraType;
use App\Entity\Lodging;
use App\Entity\TaxesPercentage;
use App\Entity\TypeLodging;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateTimeInterface;
use DateInterval;
use DatePeriod;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $pass_hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->pass_hasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $name_lodging = ['M-H 3 personnes', 'M-H 4 personnes', 'M-H 5 personnes', 'M-H 6-8 personnes', 'Caravane 2 places',
            'Caravane 4 places', 'Caravane 6 places', 'Emplacement 8m2', 'Emplacement 12m2'];
        $place_lodging = [3, 4, 5, 8, 2, 4, 6, 2, 4];
        $price_lodging = [20, 24, 27, 34, 15, 18, 24, 12, 14];
        $name_extras = ['Taxe de Séjour enfant', 'Taxe de Séjour adulte', 'Piscine enfant', 'Piscine Adulte'];
        $price_extras = [0.35, 0.6, 1, 1.5];
        $name_taxes = ['Donné au propriétaire', 'Remise des 7jours', 'Majoration Haute-Saison'];
        $percent_taxes = [35, 5, 15];
        $name_bill_cont = ['Propriétaire', 'Locataire'];
        $img = ['1.jpg', '2.jpg', '3.jpg', '4.jpeg', '5.jpeg', '6.jpeg', '7.jpeg', '8.jpg', '9.jpg', '10.jpg', '11.jpeg',
            '12.jpg', '13.jpg', '14.jpg', '15.jpg', '16.jpeg', '17.jpg', '18.jpg', '19.jpg', '20.jpg', '21.jpg', '22.jpg',
            '23.jpg', '24.jpg', '25.jpg', '26.jpg', '27.jpg', '28.jpg', '29.jpg', '30.jpg', '31.jpg', '32.jpeg', '33.jpg',
            '34.jpg', '35.jpg', '36.jpg', '37.jpg', '38.jpg', '39.jpeg', '40.jpg', '41.jpeg', '42.jpg', '43.jpg', '44.jpg',
            '45.jpg', '46.jpg', '47.jpg', '48.jpg', '49.jpg', '50.jpeg', '51.jpg', '52.jpg', '53.jpg', '54.jpg', '55.jpg',
            '56.jpeg', '57.jpg', '58.jpeg', '59.jpg', '60.jpeg', '61.jpg', '62.jpg', '63.png', '64.jpg', '65.jpg', '66.jpg',
            '67.jpg', '68.jpg', '69.jpg', '70.jpg', '71.jpg', '72.jpg', '73.jpg', '74.jpeg', '75.jpg', '76.jpg', '77.jpeg',
            '78.jpeg', '79.jpg', '80.jpg', '81.jpg', '82.jpg', '83.jpeg', '84.jpg', '85.jpeg', '86.jpeg', '87.jpg', '88.jpg',
            '89.jpg', '90.jpg'];


        $start_date = date_create("2022-05-05");
        $end_date = date_create("2022-10-11");
        $interval = DateInterval::createFromDateString('1 day');
        $daterange = new DatePeriod($start_date, $interval, $end_date);
        foreach ($daterange as $date) {
            $dates_reservations[] = $date->format('Y-m-d');
        }


        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 181; $i++) {
            $address = new Adresses();

            if ($i < 1) {
                $address->setStreet('2 rue du Port')
                    ->setCity('Perpignan')
                    ->setPostalCode(66000);
            } else {
                $address->setStreet($faker->streetAddress)
                    ->setCity($faker->city)
                    ->setPostalCode(rand(10000, 99999));
            }
            $manager->persist($address);
            $this->addReference('adresse-' . $i, $address);
        }

        for ($i = 0; $i < 181; $i++) {
            $user = new User();
            if ($i < 1) {
                $user->setTypeUser('ROLE_ADMIN')
                    ->setMail('camping@camping.com')
                    ->setFirstName('camping ')
                    ->setLastName('espadrille')
                    ->setPassword($this->pass_hasher->hashPassword($user, 'admin'))
                    ->setIdAdresses($this->getReference('adresse-' . $i));
                $manager->persist($user);
                $this->addReference('user-' . $i, $user);
            }
            if($i > 0 && $i < 2){
                $user->setTypeUser('ROLE_USER')
                    ->setMail('toto@toto.com')
                    ->setFirstName('toto')
                    ->setLastName('toto')
                    ->setPassword($this->pass_hasher->hashPassword($user, 'toto'))
                    ->setIdAdresses($this->getReference('adresse-' . $i));
                $manager->persist($user);
                $this->addReference('user-' . $i, $user);
            }
            if (1 < $i && $i < 31) {
                $user = new User();
                $user->setTypeUser('ROLE_USER')
                    ->setMail($faker->email)
                    ->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setPassword($this->pass_hasher->hashPassword($user, $faker->password))
                    ->setIdAdresses($this->getReference('adresse-' . $i));
                $manager->persist($user);
                $this->addReference('user-' . $i, $user);

            }

            if ($i > 30) {
                $client = new Client();
                $client->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setAddresse($this->getReference('adresse-' . $i));
                $manager->persist($client);
                $this->addReference('client-' . ($i - 31), $client);
            }
        }


        for ($i = 0; $i < count($name_lodging); $i++) {
            $type_lodging = new TypeLodging();
            $type_lodging->setType($name_lodging[$i])
                ->setPlaces($place_lodging[$i])
                ->setPrice($price_lodging[$i]);
            $manager->persist($type_lodging);
            $this->addReference('type-lodging-' . $i, $type_lodging);
        }


        for ($i = 0; $i < count($name_taxes); $i++) {
            $taxes = new TaxesPercentage();
            $taxes->setTypeTaxes($name_taxes[$i])
                ->setPercent($percent_taxes[$i]);
            $manager->persist($taxes);
        }

        for ($i = 0; $i < 90; $i++) {
            $lodging = new Lodging();

            if ($i < 20) {
                $lodging->setIdUser($this->getReference('user-' . '0'));
                $lodging->setIdTypelodging($this->getReference('type-lodging-' . rand(0, 3)));
                $lodging->setName('Mobil-Home ' . $faker->company);

            }
            if ($i >= 20 && $i < 50) {
                $lodging->setIdUser($this->getReference('user-' . ($i - 20)));
                $lodging->setIdTypelodging($this->getReference('type-lodging-' . rand(0, 3)));
                $lodging->setName('Mobil-Home ' . $faker->company);
            }
            if (50 <= $i && $i < 60) {
                $lodging->setIdUser($this->getReference('user-' . '0'));
                $lodging->setIdTypelodging($this->getReference('type-lodging-' . rand(4, 6)));
                $lodging->setName('Caravane ' . $faker->company);
            }
            if ($i >= 60) {
                $lodging->setIdUser($this->getReference('user-' . '0'));
                $lodging->setIdTypelodging($this->getReference('type-lodging-' . rand(7, 8)));
                $lodging->setName('Emplacement ' . $faker->company);
            }
            $lodging->setFilename($img[$i]);
            $lodging->setUpdateAt($faker->dateTime('now'));
            $manager->persist($lodging);
            $this->addReference('lodging-' . $i, $lodging);
        }

        for ($i = 0; $i < count($name_extras); $i++) {
            $extras_infos = new ExtraType();
            $extras_infos->setLabel($name_extras[$i])
                ->setPrice($price_extras[$i]);
            $manager->persist($extras_infos);
            $this->addReference('extra-type-' . $i, $extras_infos);
        }

        for ($i = 0; $i < 150; $i++) {
            $randNumberChild = rand(0, 4);
            $randNumberAdult = rand(1, 4);
            $randNumberNights = rand(3, 10);
            $index_jours = rand(10, 147);
            $date_arrival = $dates_reservations[$index_jours];
            $date_departure = $dates_reservations[($index_jours + $randNumberNights) - 1];
            //$date = $dates_reservations[($index_jours + $j)];
            //$dateErasing = $dates_reservations[($index_jours + $randNumberNights)-1];
            $bookings = new Bookings();
            $bookings->setClient($this->getReference('client-' . $i))
                ->setIdLodging($this->getReference('lodging-' . rand(0, 89)))
                //->setBookingNumber($i + 1)
                ->setNbAdults($randNumberAdult)
                ->setNbChildren($randNumberChild)
                ->setDateArrival(\DateTime::createFromFormat('Y-m-d', $date_arrival))
                ->setDateDeparture(\DateTime::createFromFormat('Y-m-d', $date_departure));
            //->setDate(\DateTime::createFromFormat('Y-m-d' , $date))
            //->setDateErasing(\DateTime::createFromFormat('Y-m-d' , $dateErasing))
            $manager->persist($bookings);
            $this->addReference('booking-' . $i, $bookings);

            for ($k = 0; $k < 4; $k++) {
                if ($k < 1 && $randNumberChild > 0) {
                    $extras = new Extras();
                    $extras->setBooking($this->getReference('booking-' . $i))
                        ->setExtraType($this->getReference('extra-type-' . $k))
                        //->setBookingNumber($i + 1)
                        ->setQuantity($randNumberChild);
                    $manager->persist($extras);
                }
                if ($k > 0 && $k < 2) {
                    $extras = new Extras();
                    $extras->setBooking($this->getReference('booking-' . $i))
                        ->setExtraType($this->getReference('extra-type-' . $k))
                        //->setBookingNumber($i + 1)
                        ->setQuantity($randNumberAdult);
                    $manager->persist($extras);
                }
                if ($k === 2 && $randNumberChild > 0) {
                    $extras = new Extras();
                    $extras->setBooking($this->getReference('booking-' . $i));
                    $extras->setExtraType($this->getReference('extra-type-' . $k))
                        //->setBookingNumber($i + 1)
                        ->setQuantity(rand(1, $randNumberChild));
                }
                if ($k === 3) {
                    $extras = new Extras();
                    $extras->setBooking($this->getReference('booking-' . $i));
                    $extras->setExtraType($this->getReference('extra-type-' . $k))
                        //->setBookingNumber($i + 1)
                        ->setQuantity(rand(1, $randNumberAdult));
                    $manager->persist($extras);
                }
            }
        }


        for ($i = 0; $i < 150; $i++) {
            $bill_skeleton = new BillsSkeleton();
            $bill_skeleton->setDateEdition($faker->dateTime)
                ->setSiretNumber(rand(11111, 999999))
                ->setClientNumber(rand(1, 100))
                ->setTitle($name_bill_cont[rand(0, 1)])
                ->setTransmitter('Camping de l\'Espapadrille Volante')
                ->setNameLodging($faker->company)
                ->setNameClient($faker->name)
                ->setDateErasing($faker->dateTime);
            $manager->persist($bill_skeleton);
        }

        for ($i = 0; $i < 150; $i++) {
            $bill_content = new BillsContent();
            $bill_content->setIdBillSkeleton($bill_skeleton)
                ->setBillNumber(rand(1405, 4504))
                ->setDesignation($name_extras[rand(0, 3)])
                ->setQuantity(rand(1, 5))
                ->setPrice($price_extras[rand(0, 3)]);
            $manager->persist($bill_content);
        }
        $manager->flush();
    }
}

