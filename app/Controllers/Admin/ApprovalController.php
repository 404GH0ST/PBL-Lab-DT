<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Publication;
use App\Models\Activity;
use App\Models\Course;
use App\Models\FokusRiset;
use App\Models\Fasilitas;
use App\Models\Contact;
use App\Models\VisiMisi;


class ApprovalController extends Controller
{
    protected $newsModel;
    protected $galleryModel;
    protected $publicationModel;
    protected $activityModel;
    protected $courseModel;
    protected $fokusRisetModel;
    protected $fasilitasModel;
    protected $contactModel;
    protected $visiMisiModel;

    public function __construct()
    {
        // Restrict access to admins only
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/admin/dashboard');
            exit;
        }

        $this->newsModel = $this->loadModel(News::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->activityModel = $this->loadModel(Activity::class);
        $this->courseModel = $this->loadModel(Course::class);
        $this->fokusRisetModel = $this->loadModel(FokusRiset::class);
        $this->fasilitasModel = $this->loadModel(Fasilitas::class);
        $this->contactModel = $this->loadModel(Contact::class);
        $this->visiMisiModel = $this->loadModel(VisiMisi::class);
    }

    public function index()
    {

        // News
        $allNews = $this->newsModel->getAllNews();
        $pendingNews = array_filter($allNews, function ($item) {
            return $item['status'] === 'pending';
        });

        // Gallery
        $allGallery = $this->galleryModel->getAllPhotos();
        $pendingGallery = array_filter($allGallery, function ($item) {
            return $item['status'] === 'pending';
        });

        // Publications
        $allPublications = $this->publicationModel->getAllPublications();
        $pendingPublications = array_filter($allPublications, function ($item) {
            return $item['status'] === 'pending';
        });

        // Activities
        $allActivities = $this->activityModel->getAllActivities();
        $pendingActivities = array_filter($allActivities, function ($item) {
            return isset($item['status']) && $item['status'] === 'pending';
        });

        // Courses
        $allCourses = $this->courseModel->getAllCourses();
        $pendingCourses = array_filter($allCourses, function ($item) {
            return isset($item['status']) && $item['status'] === 'pending';
        });

        // Research Focus
        $allFocus = $this->fokusRisetModel->getAllFocus();
        $pendingFocus = array_filter($allFocus, function ($item) {
            return isset($item['status']) && $item['status'] === 'pending';
        });

        // Fasilitas
        $allFasilitas = $this->fasilitasModel->getAllFacilities();
        $pendingFasilitas = array_filter($allFasilitas, function ($item) {
            return isset($item['status']) && $item['status'] === 'pending';
        });

        // Info Lab
        $infoLab = $this->contactModel->getContactInfo();
        $pendingInfoLab = ($infoLab && isset($infoLab['status']) && $infoLab['status'] === 'pending') ? [$infoLab] : [];

        // Visi Misi
        $visiMisiList = $this->visiMisiModel->getAllVisiMisi();
        $pendingVisiMisi = array_filter($visiMisiList, function ($item) {
            return isset($item['status']) && $item['status'] === 'pending';
        });

        return $this->view('admin/approvals/index', [
            'pendingNews' => $pendingNews,
            'pendingGallery' => $pendingGallery,
            'pendingPublications' => $pendingPublications,
            'pendingActivities' => $pendingActivities,
            'pendingCourses' => $pendingCourses,
            'pendingFocus' => $pendingFocus,
            'pendingFasilitas' => $pendingFasilitas,
            'pendingInfoLab' => $pendingInfoLab,
            'pendingVisiMisi' => $pendingVisiMisi,
            'pageTitle' => 'Persetujuan Tertunda',
            'layout' => 'layouts/admin'
        ]);
    }

    public function approve($type, $id)
    {
        $adminId = $_SESSION['user']['id'] ?? null;

        switch ($type) {
            case 'news':
                $this->newsModel->updateNews($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'gallery':
                $this->galleryModel->updatePhoto($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'publication':
                $this->publicationModel->updatePublication($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'activity':
                $this->activityModel->updateActivity($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'course':
                $this->courseModel->updateCourse($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'focus':
                $this->fokusRisetModel->updateFocus($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'fasilitas':
                $this->fasilitasModel->updateFacility($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'info_lab':
                $this->contactModel->updateContactInfo(['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
            case 'visi_misi':
                $this->visiMisiModel->updateVisiMisi($id, ['status' => 'approved', 'id_admin_penilai' => $adminId]);
                break;
        }

        $this->redirect('/admin/approvals?type=' . $type);
    }

    public function reject($type, $id)
    {
        $adminId = $_SESSION['user']['id'] ?? null;
        $note = $_POST['catatan_admin'] ?? null;

        switch ($type) {
            case 'news':
                $this->newsModel->updateNews($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'gallery':
                $this->galleryModel->updatePhoto($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'publication':
                $this->publicationModel->updatePublication($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'activity':
                $this->activityModel->updateActivity($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'course':
                $this->courseModel->updateCourse($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'focus':
                $this->fokusRisetModel->updateFocus($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'fasilitas':
                $this->fasilitasModel->updateFacility($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'info_lab':
                // Note: Contact model updateContactInfo takes array, not ID (singleton)
                $this->contactModel->updateContactInfo(['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
            case 'visi_misi':
                $this->visiMisiModel->updateVisiMisi($id, ['status' => 'rejected', 'id_admin_penilai' => $adminId, 'catatan_admin' => $note]);
                break;
        }

        $this->redirect('/admin/approvals?type=' . $type);
    }
}
