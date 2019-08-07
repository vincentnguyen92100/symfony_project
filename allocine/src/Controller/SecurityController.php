<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_Registration")
     */
    public function registration(Request $request, ObjectManager $manager){
        $user = new Users();

        $form = $this->createForm(registrationType::class, $user);

        $form->handleRequest($request);

        $user->setUnsubscribe(false);
        $user->setBanned(false);
        $user->setAdmin(false);




        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
