<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Publication; // Assuming you have a Publication model


class ApprovalController extends Controller
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

    public function index()
    {
        // Fetch pending items
        // Note: We need to ensure models have methods to filter by status or we filter the results here
        // For efficiency, adding getPending* methods to models would be better, but for now we can filter if needed.
        // Assuming models return arrays.

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
        // Assuming Publication model has getAllPublications
        $allPublications = $this->publicationModel->getAllPublications();
        $pendingPublications = array_filter($allPublications, function ($item) {
            return $item['status'] === 'pending';
        });

        return $this->view('admin/approvals/index', [
            'pendingNews' => $pendingNews,
            'pendingGallery' => $pendingGallery,
            'pendingPublications' => $pendingPublications,
            'pageTitle' => 'Pending Approvals',
            'layout' => 'layouts/admin'
        ]);
    }

    public function approve($type, $id)
    {
        $adminId = $_SESSION['user']['id_anggota'] ?? null; // Assuming session stores user info

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
        }

        $this->redirect('/admin/approvals');
    }

    public function reject($type, $id)
    {
        $adminId = $_SESSION['user']['id_anggota'] ?? null;
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
        }

        $this->redirect('/admin/approvals');
    }
}
