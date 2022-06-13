<?php

namespace App\Controller;

use App\Entity\Lodging;
use App\Form\AdminLodgingType;
use App\Form\AdminUserType;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\LodgingRepository;
use App\Repository\TaxesPercentageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{

    public function __construct(LodgingRepository $lodgingRepository,
                                TaxesPercentageRepository  $taxesPercentageRepository,
                                UserRepository $userRepository)
    {
        $this->lodgingRepo  = $lodgingRepository;
        $this->taxesRepo    = $taxesPercentageRepository;
        $this->userRepo     = $userRepository;
    }

    /**
     * @Route("/admin", name="app_admin", methods={"GET"})
     * @return Response
     */
    public function homeAdmin()
    {
        return $this->render('admin/admin_page.html.twig', []);
    }

    /**
     * @Route("/user", name="app_user", methods={"GET"})
     * @return Response
     */
    public function homeUser(): Response
    {
        $idUser = $this->getUser()->getId();
        $lodgings = $this->lodgingRepo->findBy(['id_user' => $idUser]);
        $taxesGain = $this->taxesRepo->findOneBy(['type_taxes' => 'Donné au propriétaire']);
        $taxesRent = $this->taxesRepo->findOneBy(['type_taxes' => 'Remise des 7jours']);


        $this->redirectToRoute('app_login_user');
        return $this->render('users/user_page.html.twig', [
            'lodgings'          => $lodgings,
            'taxesGain'         => $taxesGain,
            'taxesRent'         => $taxesRent
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @return void
     */
    public function logout()
    {
        $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/admin/proprietaires", name="app_list_owners", methods={"GET","POST"})
     * @return Response
     */
    public function adminOwners(): Response
    {
        $users = $this->userRepo->findAll();
        return $this->render('admin/admin.owners.html.twig', [
            'users'        => $users
        ]);
    }

    /**
     * @Route("/admin/ajouter_proprietaire/{id}", name="app_add_owner", methods={"GET","POST"}, requirements={"id": "\d+"})
     * @return void
     */
    public function addOwner(int $id = -1, Request $request, ManagerRegistry $manager)
    {

        $user = ( $id > 0 ) ? ( $this->userRepo->find($id) ) : ( new User() );
        $formulaire = $this->createForm(AdminUserType::class, $user);
        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $em =  $manager->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Le propriétaire a bien été ajouté");
            return $this->redirectToRoute("app_list_owners");
        }
        return $this->render("admin/edit_owners.html.twig",[
            "form" => $formulaire->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer_proprietaire/{id}", name="app_del_owner", methods={"POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->get('_token'))){
            $em = $managerRegistry->getManager();
            $user = $this->userRepo->find($id);
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "L'utilisateur a bien été effacé");
            return $this->redirectToRoute("app_list_owners");
        } else {
            return new Response("<h1>Vous n'avez pas les droits nécessaires, raclure de bidet</h1>");
        }

    }

    /**
     * @Route("/admin/logements", name="app_list_lodgings", methods={"GET","POST"})
     * @return Response
     */
    public function adminLodgings(): Response
    {
        $lodgings = $this->lodgingRepo->findAll();
        return $this->render('admin/admin.lodgings.html.twig', [
            'lodgings'        => $lodgings
        ]);
    }

    /**
     * @Route("/admin/ajouter_logement/{id}", name="app_add_lodging", methods={"GET","POST"}, requirements={"id": "\d+"})
     * @return void
     */
    public function addLodging(int $id = -1, Request $request, ManagerRegistry $manager)
    {

        $lodging = ( $id > 0 ) ? ( $this->lodgingRepo->find($id) ) : ( new Lodging() );
        $formulaire = $this->createForm(AdminLodgingType::class, $lodging);

        $formulaire->handleRequest($request);
        if($formulaire->isSubmitted() && $formulaire->isValid()){
            $em = $manager->getManager();
            $em->persist($lodging);
            $em->flush();
            $this->addFlash('success', "Le logement a bien été ajouté");
            return $this->redirectToRoute("app_list_lodgings");
        }
        return $this->render("admin/edit_lodgings.html.twig",[
            "form" => $formulaire->createView()
        ]);
    }

    /**
     * @Route("/admin/supprimer_logement/{id}", name="app_del_lodging", methods={"POST"}, requirements={"id": "\d+"})
     * @param int $id
     * @return void
     */
    public function deleteLodging(int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        if($this->isCsrfTokenValid('delete'.$id, $request->get('_token'))){
            $em = $managerRegistry->getManager();
            $lodging = $this->lodgingRepo->find($id);
            $em->remove($lodging);
            $em->flush();
            $this->addFlash('success', "L'utilisateur a bien été effacé");
            return $this->redirectToRoute("app_list_lodgings");
        } else {
            return new Response("<h1>Vous n'avez pas les droits nécessaires, raclure de bidet</h1>");
        }

    }
    
    
}