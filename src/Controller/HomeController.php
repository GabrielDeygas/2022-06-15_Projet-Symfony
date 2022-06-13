<?php

namespace App\Controller;

use App\Entity\TaxesPercentage;
use App\Repository\ExtraTypeRepository;
use App\Repository\TaxesPercentageRepository;
use App\Repository\TypeLodgingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{

    public function __construct( TypeLodgingRepository $typeLodgingRepository, TaxesPercentageRepository $taxesPercentage,
                                ExtraTypeRepository $extraTypeRepository)
    {
        $this->typeLodgingRepo  = $typeLodgingRepository;
        $this->taxePercentRepo  = $taxesPercentage;
        $this->extraTypeRepo    = $extraTypeRepository;
    }

    /**
     * @Route("/home", name="app_home", methods={"GET", "POST"})
     * @return Response
     */
    public function home(): Response
    {
        return $this->render("front/home.html.twig", []);
    }

    /**
     * @Route("/login", name="app_login")
     * @return void
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error      = $authenticationUtils->getLastAuthenticationError();
        $lastIdent  = $authenticationUtils->getLastUsername();
        return $this->render('front/form/login.html.twig', [
            'lastIdent'         => $lastIdent,
            'error'             => $error
        ]);
    }

    /**
     * @Route("/login_user", name="app_login_user")
     * @return void
     */
    public function loginUser(AuthenticationUtils $authenticationUtils)
    {
        $error      = $authenticationUtils->getLastAuthenticationError();
        $lastIdent  = $authenticationUtils->getLastUsername();
        return $this->render('front/form/loginuser.html.twig', [
            'lastIdent'         => $lastIdent,
            'error'             => $error
        ]);
    }

    /**
     * @Route("/nos_tarifs", name="app_prices", methods={"GET"})
     * @return Response
     */
    public function prices(): Response
    {

        $lodgingType    = $this->typeLodgingRepo->findAll();
        $percent        = $this->taxePercentRepo->findAll();
        $extraType      = $this->extraTypeRepo->findAll();

        return $this->render("front/prices.html.twig", [
            'lodgingType'       => $lodgingType,
            'percent'           => $percent,
            'extraType'         => $extraType
        ]);
    }

}