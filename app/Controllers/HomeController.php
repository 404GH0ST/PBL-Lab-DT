<?php

namespace App\Controllers;

use Core\Controller;


/**
 * Home Controller
 */
class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        return $this->view('home', [
            'title' => 'Welcome to Profile Lab DT',
            'message' => 'Welcome to Profile Lab DT'
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
        return $this->view('gallery', [
            'title' => 'Gallery - Profile Lab DT'
        ]);
    }

    public function publicationPage()
    {
        return $this->view('publications', [
            'title' => 'Publication - Profile Lab DT'
        ]);
    }

     public function NewsPage()
    {
        return $this->view('news', [
            'title' => 'News - Profile Lab DT'
        ]);
    }


    public function loginPage()
    {
        return $this->view('login', [
            'title' => 'Login - Profile Lab DT'
        ]);
    }
}