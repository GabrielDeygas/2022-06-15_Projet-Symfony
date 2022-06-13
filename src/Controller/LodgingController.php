<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Entity\Bookings;
use App\Entity\Client;
use App\Entity\Extras;
use App\Entity\Lodging;
use App\Form\BookingType;
use App\Form\AdressType;
use App\Form\ClientType;
use App\Form\ExtrasType;
use App\Repository\ExtraTypeRepository;
use App\Repository\LodgingRepository;
use App\Repository\TypeLodgingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LodgingController extends AbstractController
{

    public function __construct(LodgingRepository $lodgingsRepository, TypeLodgingRepository $typeLodgingRepository,
    ExtraTypeRepository $extraTypeRepository )
    {
        $this->lodgingsRepo     = $lodgingsRepository;
        $this->typeLodgingsRepo = $typeLodgingRepository;
        $this->extraTypeRepo = $extraTypeRepository;
    }

    /**
     * @Route("/nos_logements", name="app_lodgings", methods={"GET"})
     * @return Response
     */
    public function lodgings(): Response
    {
        $typeLodgings   = $this->typeLodgingsRepo->findAll();
        $lodgings       = $this->lodgingsRepo->findAll();

        return $this->render("front/lodgings.html.twig", [
            "lodgings"      => $lodgings,
            "typeLodgings"  => $typeLodgings
        ]);
    }

    /**
     * @Route("/logement/{id}", name="app_lodgingsdetails", methods={"GET","POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @return Response
     */
    public function lodgingDetail(int $id = -1): Response
    {
        $lodging        = $this->lodgingsRepo->find($id);
        $infoLodging    = $this->typeLodgingsRepo->find($lodging->getIdTypelodging());

        return $this->render("front/details_lodging.html.twig", [
            "lodging"       => $lodging,
            "infoLodging"   => $infoLodging,
        ]);
    }

    /**
     * @Route("/creerbooking/{id}", name="app_create_booking", methods={"GET","POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $manager
     * @return Response
     */
    public function bookingForm(int $id = -1, Request $request, ManagerRegistry $manager): Response
    {

        $lodging        = $this->lodgingsRepo->find($id);
        $infoLodging    = $this->typeLodgingsRepo->find($lodging->getIdTypelodging());

        $booking        = new Bookings();
        $formulaire     = $this->createForm(BookingType::class, $booking);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $em = $manager->getManager();
            $booking->setIdLodging($lodging);
            $em->persist($booking);
            $em->flush();
            return $this->redirectToRoute('app_create_extras');
        }

        return $this->render("front/details_lodging_booking.html.twig", [
            "form"          => $formulaire->createView(),
            "lodging"       => $lodging,
            "infoLodging"   => $infoLodging,
            "id"            => $id,
            "booking"       => $booking
        ]);
    }

    /**
     * @Route("/creerextras/{id}", name="app_create_extras", methods={"GET","POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $manager
     * @param Bookings $booking
     * @return Response
     */
    public function extrasform(int $id = -1, Request $request, ManagerRegistry $manager): Response
    {

        $lodging        = $this->lodgingsRepo->find($id);
        $infoLodging    = $this->typeLodgingsRepo->find($lodging->getIdTypelodging());

        $extras         = new Extras();
        $formulaire     = $this->createForm(ExtrasType::class, $extras);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $em = $manager->getManager();
            //$extras->setBooking($booking);
            $em->persist($extras);
            $em->flush();
            return $this->redirectToRoute('app_lodgings');
        }

        return $this->render("front/extras_bookings.html.twig", [
            "form"          => $formulaire->createView(),
            "lodging"       => $lodging,
            "infoLodging"   => $infoLodging,
            "id"            => $id,
           // "booking"       => $booking
        ]);

    }
}