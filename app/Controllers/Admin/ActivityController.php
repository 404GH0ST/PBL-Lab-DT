<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Activity;
use App\Models\Member;

class ActivityController extends Controller
{
    private $activityModel;
    private $memberModel;

    public function __construct()
    {
        $this->activityModel = $this->loadModel(Activity::class);
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $activities = $this->activityModel->getAllActivities();
        $members = $this->memberModel->getAllMembers();
        return $this->view('admin/activities/index', [
            'title' => 'Manajemen Kegiatan',
            'activities' => $activities,
            'members' => $members,
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = [
            'judul_kegiatan' => $_POST['judul_kegiatan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar'] ?? 'bi bi-activity',
            'id_penulis' => $_POST['id_penulis'] ?? $_SESSION['user']['id']
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
            'gambar' => $_POST['gambar'],
            'id_penulis' => $_POST['id_penulis'] ?? $_SESSION['user']['id']
        ];

        // Reset status to pending if not admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $data['status'] = 'pending';
        }

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
