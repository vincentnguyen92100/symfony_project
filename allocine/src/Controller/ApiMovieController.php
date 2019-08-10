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


        
        return $this->render('api_movie/index.html.twig', [
            'Movies'=> $MoviesTab,'genres'=> $categoryTab
        ]);
     
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
       
        return $this->render('api_movie/details.html.twig', [
        'details'=> $MoviesTab, 'trailer'=> $trailer
        ]);
        
    }


    /**
     * @Route("/categories/{id}", name="categories")
     */
    public function categoriesMovies(SerializerInterface $serializer, $id)
    {
        $Movies=file_get_contents('https://api.themoviedb.org/3/discover/movie?api_key=f5621d217c7c61f28b699c88eade6ebf&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres='.$id);
        $MoviesTab=$serializer->decode($Movies, 'json');

        $category=file_get_contents('https://api.themoviedb.org/3/genre/movie/list?api_key=fe9e318b04bec15f80e7ddf05a462e39');
        $categoryTab=$serializer->decode($category, 'json');

        // dump($categoryTab);
        // die();
        return $this->render('api_movie/categories.html.twig', [
            'Movies'=> $MoviesTab, 'genres'=> $categoryTab
        ]);
    
    }


}
