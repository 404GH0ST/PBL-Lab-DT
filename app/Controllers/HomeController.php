<?php

namespace App\Controllers;

use Core\Controller;
use Core\Pagination;
use App\Models\VisiMisi;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Publication;
use App\Models\Member;
use App\Models\Fasilitas;

/**
 * Home Controller
 */
class HomeController extends Controller
{
    protected $newsModel;
    protected $galleryModel;
    protected $publicationModel;
    protected $memberModel;
    protected $fasilitasModel;

    public function __construct()
    {
        $this->newsModel = $this->loadModel(News::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->memberModel = $this->loadModel(Member::class);
        $this->fasilitasModel = $this->loadModel(Fasilitas::class);
    }

    /**
     * Display the home page
     */
    public function index()
    {
        $visiMisiModel = $this->loadModel(VisiMisi::class);
        $visi = $visiMisiModel->getVisi();
        $misi = $visiMisiModel->getMisi();

        // Use stored procedure to get sorted publications
        $recentPublications = $this->publicationModel->getSortedPublications(4);
        $mostCitedPublications = $this->publicationModel->getMostCitedPublications(3);
        $gallery = $this->galleryModel->getApprovedPhotos();
        $gallery = array_slice($gallery, 0, 6);

        // Fetch members for homepage
        $headOfLab = $this->memberModel->getMembersByRole('admin');
        $labMembers = $this->memberModel->getMembersByRole('operator');

        // Limit members if needed, e.g., take top 3
        $labMembers = array_slice($labMembers, 0, 3);

        return $this->view('home', [
            'title' => 'Welcome to Profile Lab DT',
            'message' => 'Welcome to Profile Lab DT',
            'visi' => $visi,
            'misi' => $misi,
            'recentPublications' => $recentPublications,
            'mostCitedPublications' => $mostCitedPublications,
            'gallery' => $gallery,
            'headOfLab' => $headOfLab,
            'labMembers' => $labMembers
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
        $facilities = $this->fasilitasModel->getAllFacilities();

        return $this->view('facility', [
            'title' => 'Facility - Profile Lab DT',
            'facilities' => $facilities
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

    public function NewsPage()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 9;

        // Use approved news for public listing
        $allNews = $this->newsModel->getApprovedNews();

        // Simple pagination slice (model does not provide paginated approved method)
        $total = count($allNews);
        $offset = max(0, ($page - 1) * $limit);
        $news = array_slice($allNews, $offset, $limit);

        // Basic pagination object if available
        $pagination = null;
        if (class_exists('\Core\Pagination')) {
            $pagination = new Pagination($total, $limit, $page);
        }

        return $this->view('news', [
            'title' => 'News - Profile Lab DT',
            'news' => $news,
            'pagination' => $pagination,
            'baseUrl' => '/news'
        ]);
    }

    public function newsDetail($slug)
    {
        $article = $this->newsModel->getNewsBySlug($slug);

        if (!$article) {
            return $this->notFound();
        }

        return $this->view('news_detail', [
            'title' => $article['judul'] . ' - Profile Lab DT',
            'article' => $article
        ]);
    }


    public function loginPage()
    {
        return $this->view('login', [
            'title' => 'Login - Profile Lab DT'
        ]);
    }

    public function memberDetail($id)
    {
        $member = $this->memberModel->getMemberById($id);

        if (!$member) {
            // Handle 404 or redirect
            return $this->view('404', [
                'title' => 'Page Not Found - Profile Lab DT',
                'path' => "member/{$id}"
            ]);
        }

        $news = $this->newsModel->getApprovedNewsByAuthor($id);
        $publications = $this->publicationModel->getApprovedPublicationsByAuthor($id);
        $gallery = $this->galleryModel->getApprovedPhotosByUploader($id);

        return $this->view('member_detail', [
            'title' => $member['nama_lengkap'] . ' - Profile Lab DT',
            'member' => $member,
            'news' => $news,
            'publications' => $publications,
            'gallery' => $gallery
        ]);
    }

    public function notFound()
    {
        http_response_code(404);
        return $this->view('404', [
            'title' => 'Page Not Found - Profile Lab DT'
        ]);
    }
}