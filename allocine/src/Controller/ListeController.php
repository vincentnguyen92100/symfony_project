<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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

    

}
