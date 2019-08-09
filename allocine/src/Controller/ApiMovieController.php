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
        //die();
        return $this->render('api_movie/index.html.twig', [
            'Movies'=> $MoviesTab,'genres'=> $categoryTab
        ]);
        // dump($categoryTab);
        // die();
    }

    /**
     * @Route("/movies/{id}", name="movies_details")
     */
    public function showMovies(SerializerInterface $serializer, $id)
    {
        $moviesDetails=file_get_contents('https://api.themoviedb.org/3/movie/'.$id.'?language=en-US&api_key=f5621d217c7c61f28b699c88eade6ebf');
        $MoviesTab=$serializer->decode($moviesDetails, 'json');

        $trailerDetails=file_get_contents('https://api.themoviedb.org/3/movie/'.$id.'/videos?language=en-US&api_key=f5621d217c7c61f28b699c88eade6ebf');
        $trailer=$serializer->decode($trailerDetails, 'json');
        //dump($threaler);
        //die();
        //$details = $moviesDetails->find($id);
        return $this->render('api_movie/details.html.twig', [
        'details'=> $MoviesTab, 'trailer'=> $trailer
        ]);
        
    }


    /**
     * @Route("/categorie/{id}", name="categories")
     */
    public function cotegoriesMovies(SerializerInterface $serializer, $id)
    {
        $categorieMovies=file_get_contents('https://api.themoviedb.org/3/list/'.$id.'?api_key=fe9e318b04bec15f80e7ddf05a462e39&page=2');
        $categorieTab=$serializer->decode($categorieMovies, 'json');

        $category=file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=fe9e318b04bec15f80e7ddf05a462e39');
        $categoryTab=$serializer->decode($category, 'json');

         dump($categorieTab);
         die();
        //dump($MoviesTab);
        //$MoviesObjets=$serializer->denormalize($MoviesTab, 'App\Entity\Region[]')
        //die();
        return $this->render('api_movie/categories.html.twig', [
            'categorieMovies'=> $categorieTab, 'genres'=> $categoryTab
        ]);
        // dump($categoryTab);
        // die();
    }


}
