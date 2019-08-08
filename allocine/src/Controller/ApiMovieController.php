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
        $Movies=file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key=f5621d217c7c61f28b699c88eade6ebf&language=en-US&page=10');
        $MoviesTab=$serializer->decode($Movies, 'json');

        $category=file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=fe9e318b04bec15f80e7ddf05a462e39');
        $categoryTab=$serializer->decode($category, 'json');


        // dump($categoryTab);
        // die();
        //dump($MoviesTab);
        //$MoviesObjets=$serializer->denormalize($MoviesTab, 'App\Entity\Region[]')
        
        return $this->render('api_movie/index.html.twig', [
            'Movies'=> $MoviesTab,'genres'=> $categoryTab
        ]);
        // dump($categoryTab);
        // die();
    }


}
