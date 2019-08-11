<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Entity\Users;
use App\Form\ListeType;
use App\Repository\ListeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListeController extends AbstractController
{
    /**
     * @Route("/list/new", name="new_list")
     * 
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $liste = new Liste();
        $users = $this->getUser();
        $form = $this->createForm(ListeType::class, $liste);

        // $form = $this->createFormBuilder($liste)
        //              ->add('name')
        //              ->add('description')
        //              ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $liste->setusers($users);

            $manager->persist($liste);
            $manager->flush();
            
        }

        return $this->render('liste/createListe.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/list/index", name="list_index", methods={"GET"})
     */
    public function index(ListeRepository $ListeRepository): Response
    {
        $users = $this->getUser();
        // dump($users);
        // die();
        return $this->render('liste/index.html.twig', [
            'listes' => $ListeRepository->findall($users),
        ]);
    }

}
