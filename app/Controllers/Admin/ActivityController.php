<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Activity;

class ActivityController extends Controller
{
    private $activityModel;

    public function __construct()
    {
        $this->activityModel = $this->loadModel(Activity::class);
    }

    public function index()
    {
        $activities = $this->activityModel->getAllActivities();
        return $this->view('admin/activities/index', [
            'title' => 'Manajemen Kegiatan',
            'activities' => $activities,
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = [
            'judul_kegiatan' => $_POST['judul_kegiatan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar'] ?? 'bi bi-activity' // Default icon if not provided
        ];

        if ($this->activityModel->createActivity($data)) {
            $_SESSION['flash_success'] = 'Kegiatan berhasil ditambahkan.';
            header('Location: /admin/activities');
            exit;
        }
    }

    public function update($id)
    {
        $data = [
            'judul_kegiatan' => $_POST['judul_kegiatan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar']
        ];

        if ($this->activityModel->updateActivity($id, $data)) {
            $_SESSION['flash_success'] = 'Kegiatan berhasil diperbarui.';
            header('Location: /admin/activities');
            exit;
        }
    }

    public function destroy($id)
    {
        $this->activityModel->deleteActivity($id);
        $_SESSION['flash_success'] = 'Kegiatan berhasil dihapus.';
        header('Location: /admin/activities');
        exit;
    }
}
