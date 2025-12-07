<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\VisiMisi;

class VisiMisiController extends Controller
{
    protected $visiMisiModel;

    public function __construct()
    {
        $this->visiMisiModel = $this->loadModel(VisiMisi::class);
    }

    public function index()
    {
        $visiMisi = $this->visiMisiModel->getAllVisiMisi();
        return $this->view('admin/visimisi/index', ['visiMisi' => $visiMisi, 'pageTitle' => 'Manajemen Visi Misi', 'layout' => 'layouts/admin']);
    }

    public function store()
    {
        $data = $_POST;

        $userId = $_SESSION['user']['id'] ?? null;
        $userRole = $_SESSION['user']['role'] ?? 'operator';

        // Admins update directly (approved), proper workflow for others (pending)
        $status = ($userRole === 'admin') ? 'approved' : 'pending';

        $extraData = [
            'id_editor' => $userId,
            'status' => $status
        ];

        // If admin, they act as the validator too
        if ($status === 'approved') {
            $extraData['id_admin_penilai'] = $userId;
            $extraData['catatan_admin'] = 'Auto-approved by author';
        }

        // Handle standard form submission (visi and misi)
        if (isset($data['visi'])) {
            $this->visiMisiModel->upsertVisiMisi('visi', $data['visi'], $extraData);
        }
        if (isset($data['misi'])) {
            $this->visiMisiModel->upsertVisiMisi('misi', $data['misi'], $extraData);
        }

        // Set flash message
        if ($status === 'approved') {
            $_SESSION['flash_success'] = 'Visi dan Misi berhasil diperbarui.';
        } else {
            $_SESSION['flash_success'] = 'Perubahan Visi dan Misi berhasil dikirim untuk persetujuan Admin.';
        }

        // Redirect back
        $this->redirect('/admin/visimisi');
    }

    public function update($id)
    {
        $data = $_POST;

        $this->visiMisiModel->updateVisiMisi($id, $data);
        $this->redirect('/admin/visimisi');
    }

    public function destroy($id)
    {
        $this->visiMisiModel->deleteVisiMisi($id);
        $this->redirect('/admin/visimisi');
    }
}
