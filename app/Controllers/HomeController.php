<?php

namespace App\Controllers;

use Core\Controller;
use Core\Pagination;
use App\Models\VisiMisi;
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
        $visiMisiModel = $this->loadModel(VisiMisi::class);
        $visi = $visiMisiModel->getVisi();
        $misi = $visiMisiModel->getMisi();
        $recentPublications = $this->publicationModel->getApprovedPublications();
        // Limit to 4 for the home page
        $recentPublications = array_slice($recentPublications, 0, 4);

        return $this->view('home', [
            'title' => 'Welcome to Profile Lab DT',
            'message' => 'Welcome to Profile Lab DT',
            'visi' => $visi,
            'misi' => $misi,
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
        $page = $_GET['page'] ?? 1;
        $limit = 9;
        $total = $this->galleryModel->countApprovedPhotos();
        $pagination = new Pagination($total, $limit, $page);

        $photos = $this->galleryModel->getPaginatedApprovedPhotos($limit, $pagination->getOffset());

        return $this->view('gallery', [
            'title' => 'Gallery - Profile Lab DT',
            'photos' => $photos,
            'pagination' => $pagination,
            'baseUrl' => '/gallery'
        ]);
    }

    public function publicationPage()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $total = $this->publicationModel->countApprovedPublications();
        $pagination = new Pagination($total, $limit, $page);

        $publications = $this->publicationModel->getPaginatedApprovedPublications($limit, $pagination->getOffset());

        return $this->view('publications', [
            'title' => 'Publication - Profile Lab DT',
            'publications' => $publications,
            'pagination' => $pagination,
            'baseUrl' => '/publications'
        ]);
    }

    public function loginPage()
    {
        return $this->view('login', [
            'title' => 'Login - Profile Lab DT'
        ]);
    }
}