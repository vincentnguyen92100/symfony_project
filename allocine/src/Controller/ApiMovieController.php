<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiMovieController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function popularMovies(SerializerInterface $serializer)
    {
        $Movies=file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key=f5621d217c7c61f28b699c88eade6ebf&language=en-US&page=1');
        $MoviesTab=$serializer->decode($Movies, 'json');
        //dump($MoviesTab);
        //$MoviesObjets=$serializer->denormalize($MoviesTab, 'App\Entity\Region[]')
        
        return $this->render('api_movie/index.html.twig', [
            'Movies'=> $MoviesTab
        ]);
       // dump($MoviesTab);
        //die();
    }

}
