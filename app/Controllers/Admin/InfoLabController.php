<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Contact;


class InfoLabController extends Controller
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = $this->loadModel(Contact::class);
    }

    public function index()
    {
        $contact = $this->contactModel->getContactInfo();

        return $this->view('admin/info-lab/index', [
            'contact' => $contact,
            'pageTitle' => 'Informasi Kontak',
            'layout' => 'layouts/admin'
        ]);
    }

    public function update()
    {
        $data = $_POST;

        $userId = $_SESSION['user']['id'] ?? null;
        $userRole = $_SESSION['user']['role'] ?? 'operator';
        $status = ($userRole === 'admin') ? 'approved' : 'pending';

        $data['id_editor'] = $userId;
        $data['status'] = $status;

        if ($status === 'approved') {
            $data['id_admin_penilai'] = $userId;
            $data['catatan_admin'] = 'Auto-approved by author';
        }

        $this->contactModel->updateContactInfo($data);

        $msg = ($status === 'approved')
            ? 'Informasi lab berhasil diperbarui.'
            : 'Perubahan informasi lab berhasil dikirim untuk persetujuan Admin.';

        $_SESSION['flash_success'] = $msg;
        $this->redirect('/admin/info-lab');
    }
}
