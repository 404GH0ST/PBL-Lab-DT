<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Contact;
use App\Models\VisiMisi;

class InfoLabController extends Controller
{
    protected $contactModel;
    protected $visiMisiModel;

    public function __construct()
    {
        $this->contactModel = $this->loadModel(Contact::class);
        $this->visiMisiModel = $this->loadModel(VisiMisi::class);
    }

    public function index()
    {
        $contact = $this->contactModel->getContactInfo();
        $struktur = $this->visiMisiModel->getByType('struktur_organisasi');

        return $this->view('admin/info-lab/index', [
            'contact' => $contact,
            'struktur' => $struktur,
            'pageTitle' => 'Informasi Kontak & Lab',
            'layout' => 'layouts/admin'
        ]);
    }

    public function update()
    {
        $data = $_POST;
        $files = $_FILES;

        $userId = $_SESSION['user']['id'] ?? null;
        $userRole = $_SESSION['user']['role'] ?? 'operator';
        $status = ($userRole === 'admin') ? 'approved' : 'pending';

        // 1. Update Contact Info
        $data['id_editor'] = $userId;
        $data['status'] = $status;

        if ($status === 'approved') {
            $data['id_admin_penilai'] = $userId;
            $data['catatan_admin'] = 'Auto-approved by author';
        }

        $this->contactModel->updateContactInfo($data);

        // 2. Handle Structure Organization Upload
        if (isset($files['struktur_image']) && $files['struktur_image']['error'] === UPLOAD_ERR_OK) {
            // Check file size (2MB limit)
            if ($files['struktur_image']['size'] > 2 * 1024 * 1024) {
                $_SESSION['flash_error'] = 'Ukuran file terlalu besar. Maksimal 2MB.';
                $this->redirect('/admin/info-lab');
                return;
            }

            $uploadDir = 'uploads/struktur/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $extension = pathinfo($files['struktur_image']['name'], PATHINFO_EXTENSION);
            $filename = 'struktur_organisasi_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($files['struktur_image']['tmp_name'], $targetPath)) {
                // Upsert into profil_lab
                $extraMap = [
                    'id_editor' => $userId,
                    'status' => $status
                ];
                if ($status === 'approved') {
                    $extraMap['id_admin_penilai'] = $userId;
                    $extraMap['catatan_admin'] = 'Auto-approved by author';
                }

                $this->visiMisiModel->upsertVisiMisi('struktur_organisasi', $filename, $extraMap);
            }
        }

        $msg = ($status === 'approved')
            ? 'Informasi lab berhasil diperbarui.'
            : 'Perubahan informasi lab berhasil dikirim untuk persetujuan Admin.';

        $_SESSION['flash_success'] = $msg;
        $this->redirect('/admin/info-lab');
    }
}
