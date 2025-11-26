<?php

namespace App\Controllers;

use Core\Controller;


/**
 * Home Controller
 */
use App\Models\News;
use App\Models\Gallery;
use App\Models\Publication;

/**
 * Home Controller
 */
class HomeController extends Controller
{
    protected $newsModel;
    protected $galleryModel;
    protected $publicationModel;

    public function __construct()
    {
        $this->newsModel = $this->loadModel(News::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->publicationModel = $this->loadModel(Publication::class);
    }

    /**
     * Display the home page
     */
    public function index()
    {
        $recentPublications = $this->publicationModel->getApprovedPublications();
        // Limit to 4 for the home page
        $recentPublications = array_slice($recentPublications, 0, 4);

        return $this->view('home', [
            'title' => 'Welcome to Profile Lab DT',
            'message' => 'Welcome to Profile Lab DT',
            'recentPublications' => $recentPublications
        ]);
    }

    /**
     * Display about page
     */
    public function aboutPage()
    {
        return $this->view('about', [
            'title' => 'About Us - Profile Lab DT'
        ]);
    }

    public function FacilityPage()
    {
        return $this->view('facility', [
            'title' => 'Facility - Profile Lab DT'
        ]);
    }

    public function galleryPage()
    {
        $photos = $this->galleryModel->getApprovedPhotos();

        return $this->view('gallery', [
            'title' => 'Gallery - Profile Lab DT',
            'photos' => $photos
        ]);
    }

    public function publicationPage()
    {
        $publications = $this->publicationModel->getApprovedPublications();

        return $this->view('publications', [
            'title' => 'Publication - Profile Lab DT',
            'publications' => $publications
        ]);
    }

    public function loginPage()
    {
        return $this->view('login', [
            'title' => 'Login - Profile Lab DT'
        ]);
    }
}