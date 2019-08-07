<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('site/home.html.twig');
    }

     /**
     * @route("/site/register", name="site_register")
     */
    public function register()
    {
        return $this->render('site/register.html.twig');
    }

    /**
     * @route("/site/login", name="site_login")
     */
    public function login()
    {
        return $this->render('site/login.html.twig');
    }
    /**
     * @Route("/site/movie/12", name="site_moviedetails")
     */
    public function show(){
        return $this->render('site/moviedetails.html.twig');
    }

   
}
