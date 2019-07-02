<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditRoleUserType;
use App\Repository\UserRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/admin")
     */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {

        /*
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
        */
        return $this->render('admin/index.html.twig');
    }

    /**
     * Liste des users
     * @Route("/list/users")
     * @param UserRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function listUsers(UserRepository $userRepository):Response
    {


        return $this->render('admin/users/list.html.twig', [
         'users' => $userRepository->findAll()
        ]);
    }


    public function changeRole(User $user, Request $request, ObjectManager $manager):Response
    {

        // Récupération du formulaire
        $formRole = $this->createForm(EditRoleUserType::class, $user);

        // On envoie les données postées au formulaire
        $formRole->handleRequest($request);

        // On vérifie que le formulaire est soumis et valide
        if ($formRole->isSubmitted() && $formRole->isValid()) {
            // On sauvegarde le form en BDD grâce au manager
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            // Ajout d'un message flash
            $this->addFlash('warning', 'Le Role a bien été modifié');

            // Redirection
            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/users/change-role.html.twig', [
            'formRole' => $formRole->createView()
        ]);

    }





    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    }












}
