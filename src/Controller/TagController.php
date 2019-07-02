<?php


namespace App\Controller;


use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{





    /**
     * Affiche et traite le formulaire d'ajout d'un Tag
     * @Route("/tag/creation", methods={"GET", "POST"})
     * @param Request $requestHTTP
     * @return Response
     */
    public function create(Request $requestHTTP):Response
    {

        // Recuperation du formulaire
        $tag = new Tag();
        $formTag = $this->createForm(TagType::class, $tag);


        // On envoie les données postées au formulaire
        $formTag->handleRequest($requestHTTP);


        // On vérifie que le formulaire est soumis et valide
        if ($formTag->isSubmitted() && $formTag->isValid()) {
            // On sauvegarde le produit en BDD grâce au manager
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            // Ajout d'un message flash
            $this->addFlash('success', 'Le Tag a bien été ajouté');

            // Redirection
            //return $this->redirectToRoute('app_product_index');
        }

        return $this->render('tag/create.html.twig', [
            'formTag' => $formTag->createView()
        ]);





    }





}