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
use App\Models\FokusRiset;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Contact;

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
    protected $fokusModel;
    protected $activityModel;
    protected $courseModel;
    protected $contactModel;
    protected $globalData = [];

    public function __construct()
    {
        $this->newsModel = $this->loadModel(News::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->memberModel = $this->loadModel(Member::class);
        $this->fasilitasModel = $this->loadModel(Fasilitas::class);
        $this->fokusModel = $this->loadModel(FokusRiset::class);
        $this->activityModel = $this->loadModel(Activity::class);
        $this->courseModel = $this->loadModel(Course::class);
        $this->contactModel = $this->loadModel(Contact::class);

        $this->globalData = [
            'infoLab' => $this->contactModel->getApprovedContactInfo()
        ];
    }

    /**
     * Override view method to inject global data
     */
    protected function view(string $view, array $data = []): string
    {
        $data = array_merge($this->globalData, $data);
        return parent::view($view, $data);
    }

    /**
     * Display the home page
     */
    public function index()
    {
        $visiMisiModel = $this->loadModel(VisiMisi::class);
        $visi = $visiMisiModel->getApprovedByType('visi');
        $misi = $visiMisiModel->getApprovedByType('misi');

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

        // Fokus riset
        $focusList = [];
        try {
            $focusList = $this->fokusModel->getApprovedFocus('ASC');
        } catch (\Exception $e) {
            $focusList = [];
        }

        // Fetch additional sections for homepage (Limited)
        $facilities = $this->fasilitasModel->getPaginatedApprovedFacilities(3, 0); // Limit 3
        $activities = $this->activityModel->getAllApprovedActivities();
        $activities = array_slice($activities, 0, 3);
        $courses = $this->courseModel->getAllApprovedCourses();
        $courses = array_slice($courses, 0, 3);

        return $this->view('home', [
            'title' => 'Welcome to Profile Lab DT',
            'message' => 'Welcome to Profile Lab DT',
            'visi' => $visi,
            'misi' => $misi,
            'recentPublications' => $recentPublications,
            'mostCitedPublications' => $mostCitedPublications,
            'gallery' => $gallery,
            'headOfLab' => $headOfLab,
            'labMembers' => $labMembers,
            'focusList' => $focusList,
            'facilities' => $facilities,
            'activities' => $activities,
            'courses' => $courses
        ]);
    }

    /**
     * Display about page
     */
    public function aboutPage()
    {
        $members = $this->memberModel->getAllMembers();
        $activities = $this->activityModel->getAllApprovedActivities();
        $courses = $this->courseModel->getAllApprovedCourses();

        return $this->view('about', [
            'title' => 'About Us - Profile Lab DT',
            'members' => $members,
            'activities' => $activities,
            'courses' => $courses
        ]);
    }

    public function FacilityPage()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 6; // Adjust limit as needed
        $total = $this->fasilitasModel->countApprovedFacilities();
        $pagination = new Pagination($total, $limit, $page);

        $facilities = $this->fasilitasModel->getPaginatedApprovedFacilities($limit, $pagination->getOffset());

        return $this->view('facility', [
            'title' => 'Facility - Profile Lab DT',
            'facilities' => $facilities,
            'pagination' => $pagination,
            'baseUrl' => '/facility'
        ]);
    }
    public function galleryPage()
    {
        $page = $_GET['page'] ?? 1;
        $category = $_GET['category'] ?? null;
        $limit = 12;

        if ($category && $category !== 'Semua') {
            $total = $this->galleryModel->countApprovedPhotosByCategory($category);
            $pagination = new Pagination($total, $limit, $page);
            $photos = $this->galleryModel->getPaginatedApprovedPhotosByCategory($limit, $pagination->getOffset(), $category);
        } else {
            $total = $this->galleryModel->countApprovedPhotos();
            $pagination = new Pagination($total, $limit, $page);
            $photos = $this->galleryModel->getPaginatedApprovedPhotos($limit, $pagination->getOffset());
        }

        return $this->view('gallery', [
            'title' => 'Gallery - Profile Lab DT',
            'photos' => $photos,
            'pagination' => $pagination,
            'baseUrl' => '/gallery',
            'currentCategory' => $category ?? 'Semua',
            'layout' => 'layouts/main'
        ]);
    }

    public function publicationPage()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 10;

        $filters = [
            'search' => $_GET['search'] ?? null,
            'year' => $_GET['year'] ?? null,
            'author' => $_GET['author'] ?? null,
            'sort' => $_GET['sort'] ?? 'Newest'
        ];

        // Fetch data for filters
        $years = $this->publicationModel->getDistinctYears();
        // Get authors who have approved publications
        // We can reuse getMembersByRole or create a specific query, 
        // but for now let's just get all members to be safe or maybe just ones with publications?
        // Let's us MemberModel::getAllMembers() for simplicity or fetch distinct authors from publication table?
        // Let's use getAllMembers for now.
        $authors = $this->memberModel->getAllMembers();

        $total = $this->publicationModel->countFilteredPublications($filters);
        $pagination = new Pagination($total, $limit, $page);
        $publications = $this->publicationModel->getFilteredPublications($filters, $limit, $pagination->getOffset());

        // Append query params to pagination URL
        $baseUrl = '/publications';
        $queryParams = [];
        if ($filters['search'])
            $queryParams['search'] = $filters['search'];
        if ($filters['year'])
            $queryParams['year'] = $filters['year'];
        if ($filters['author'])
            $queryParams['author'] = $filters['author'];
        if ($filters['sort'])
            $queryParams['sort'] = $filters['sort'];

        if (!empty($queryParams)) {
            $baseUrl .= '?' . http_build_query($queryParams);
        }

        return $this->view('publications', [
            'title' => 'Publication - Profile Lab DT',
            'publications' => $publications,
            'pagination' => $pagination,
            'baseUrl' => $baseUrl,
            'filters' => $filters,
            'years' => $years,
            'authors' => $authors
        ]);
    }

    public function NewsPage()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $keyword = $_GET['search'] ?? null;

        if ($keyword) {
            // Count result search
            $total = $this->newsModel->countSearchNews($keyword);
        } else {
            $total = $this->newsModel->countApprovedNews();
        }

        $pagination = new Pagination($total, $limit, $page);

        if ($keyword) {
            $news = $this->newsModel->searchNews($keyword, $limit, $pagination->getOffset());
        } else {
            $news = $this->newsModel->getApprovedNews($limit, $pagination->getOffset());
        }

        return $this->view('news', [
            'title' => 'News - Profile Lab DT',
            'news' => $news,
            'pagination' => $pagination,
            'baseUrl' => '/news',
            'keyword' => $keyword
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