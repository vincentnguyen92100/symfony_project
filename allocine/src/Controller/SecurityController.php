<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_Registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        
        
        $user = new Users();
        

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if(!$user->getId()){
            $user->setUnsubscribe(false);
            $user->setBanned(false);
            $user->setAdmin(false);
        }

       


 
        if($form->isSubmitted() && $form->isValid())
        {
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();
          
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }

     /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
