<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Pagination;
use App\Models\FokusRiset;
use App\Models\Member;

class FokusRisetController extends Controller
{
    protected $fokusModel;
    protected $memberModel;

    public function __construct()
    {
        $this->fokusModel = $this->loadModel(FokusRiset::class);
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $total = $this->fokusModel->countAllFocus();
        $pagination = new Pagination($total, $limit, $page);

        $focus = $this->fokusModel->getPaginatedFocus($limit, $pagination->getOffset());
        $members = $this->memberModel->getAllMembers();

        return $this->view('admin/fokus/index', [
            'focus' => $focus,
            'members' => $members,
            'pagination' => $pagination,
            'baseUrl' => '/admin/fokus',
            'pageTitle' => 'Manajemen Fokus Riset',
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = $_POST;

        $userId = $_SESSION['user']['id'] ?? null;
        $userRole = $_SESSION['user']['role'] ?? 'operator';
        $status = ($userRole === 'admin') ? 'approved' : 'pending';

        if (!isset($data['id_penulis']) || empty($data['id_penulis'])) {
            $data['id_penulis'] = $userId;
        }

        $data['id_editor'] = $userId;
        $data['status'] = $status;

        if ($status === 'approved') {
            $data['id_admin_penilai'] = $userId;
            $data['catatan_admin'] = 'Auto-approved by author';
        }

        $created = $this->fokusModel->createFocus($data);
        if ($created) {
            $msg = ($status === 'approved')
                ? 'Fokus riset berhasil ditambahkan.'
                : 'Fokus riset berhasil dikirim untuk persetujuan Admin.';
            $_SESSION['flash_success'] = $msg;
        } else {
            $_SESSION['flash_error'] = 'Gagal menambahkan fokus riset.';
        }

        $this->redirect('/admin/fokus');
    }

    public function update($id)
    {
        $data = $_POST;

        $userId = $_SESSION['user']['id'] ?? null;
        $userRole = $_SESSION['user']['role'] ?? 'operator';
        $status = ($userRole === 'admin') ? 'approved' : 'pending';

        if (!isset($data['id_penulis']) || empty($data['id_penulis'])) {
            $data['id_penulis'] = $userId;
        }

        $data['id_editor'] = $userId;
        $data['status'] = $status;

        if ($status === 'approved') {
            $data['id_admin_penilai'] = $userId;
            $data['catatan_admin'] = 'Auto-approved by author';
        }

        $updated = $this->fokusModel->updateFocus($id, $data);
        if ($updated) {
            $msg = ($status === 'approved')
                ? 'Fokus riset berhasil diperbarui.'
                : 'Perubahan fokus riset berhasil dikirim untuk persetujuan Admin.';
            $_SESSION['flash_success'] = $msg;
        } else {
            $_SESSION['flash_error'] = 'Gagal memperbarui fokus riset.';
        }

        $this->redirect('/admin/fokus');
    }

    public function destroy($id)
    {
        $deleted = $this->fokusModel->deleteFocus($id);
        if ($deleted) {
            $_SESSION['flash_success'] = 'Fokus riset berhasil dihapus.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menghapus fokus riset.';
        }

        $this->redirect('/admin/fokus');
    }
}
