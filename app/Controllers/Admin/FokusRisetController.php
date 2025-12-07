<?php

namespace App\Controllers\Admin;

use Core\Controller;
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
        $focus = $this->fokusModel->getAllFocus();

        return $this->view('admin/fokus/index', [
            'focus' => $focus,
            'pageTitle' => 'Manajemen Fokus Riset',
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = $_POST;

        // Handle icon upload (optional)
        if (isset($_FILES['ikon']) && $_FILES['ikon']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/fokus_icons/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['ikon']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['ikon']['tmp_name'], $targetPath)) {
                $data['ikon'] = 'uploads/fokus_icons/' . $fileName;
            }
        }

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

        // Handle icon upload (optional)
        if (isset($_FILES['ikon']) && $_FILES['ikon']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/fokus_icons/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['ikon']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['ikon']['tmp_name'], $targetPath)) {
                // Delete old icon if exists
                $old = $this->fokusModel->getFocusById($id);
                if ($old && !empty($old['ikon']) && file_exists(__DIR__ . '/../../../public/' . $old['ikon'])) {
                    @unlink(__DIR__ . '/../../../public/' . $old['ikon']);
                }

                $data['ikon'] = 'uploads/fokus_icons/' . $fileName;
            }
        }

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
        $item = $this->fokusModel->getFocusById($id);
        if ($item && !empty($item['ikon']) && file_exists(__DIR__ . '/../../../public/' . $item['ikon'])) {
            @unlink(__DIR__ . '/../../../public/' . $item['ikon']);
        }

        $deleted = $this->fokusModel->deleteFocus($id);
        if ($deleted) {
            $_SESSION['flash_success'] = 'Fokus riset berhasil dihapus.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menghapus fokus riset.';
        }

        $this->redirect('/admin/fokus');
    }
}
