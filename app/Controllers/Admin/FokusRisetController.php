<?php

namespace App\Controllers\Admin;

use Core\Controller;
use Core\Pagination;
use App\Models\FokusRiset;

class FokusRisetController extends Controller
{
    protected $fokusModel;

    public function __construct()
    {
        $this->fokusModel = $this->loadModel(FokusRiset::class);
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $total = $this->fokusModel->countAllFocus();
        $pagination = new Pagination($total, $limit, $page);

        $focus = $this->fokusModel->getPaginatedFocus($limit, $pagination->getOffset());

        return $this->view('admin/fokus/index', [
            'focus' => $focus,
            'pagination' => $pagination,
            'baseUrl' => '/admin/fokus',
            'pageTitle' => 'Manajemen Fokus Riset',
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = $_POST;

        $created = $this->fokusModel->createFocus($data);
        if ($created) {
            $_SESSION['flash_success'] = 'Fokus riset berhasil ditambahkan.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menambahkan fokus riset.';
        }

        $this->redirect('/admin/fokus');
    }

    public function update($id)
    {
        $data = $_POST;

        $updated = $this->fokusModel->updateFocus($id, $data);
        if ($updated) {
            $_SESSION['flash_success'] = 'Fokus riset berhasil diperbarui.';
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
