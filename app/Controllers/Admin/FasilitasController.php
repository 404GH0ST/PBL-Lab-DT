<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    protected $fasilitasModel;

    public function __construct()
    {
        $this->fasilitasModel = $this->loadModel(Fasilitas::class);
    }

    public function index()
    {
        $facilities = $this->fasilitasModel->getAllFacilities();

        return $this->view('admin/facility/index', [
            'facilities' => $facilities,
            'pageTitle' => 'Facility Management',
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = $_POST;

        // Handle Photo Upload
        if (isset($_FILES['foto_fasilitas']) && $_FILES['foto_fasilitas']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/fasilitas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['foto_fasilitas']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['foto_fasilitas']['tmp_name'], $targetPath)) {
                $data['foto_fasilitas'] = 'uploads/fasilitas/' . $fileName;
            }
        }

        $created = $this->fasilitasModel->createFacility($data);
        if ($created) {
            $_SESSION['flash_success'] = 'Fasilitas berhasil ditambahkan.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menambahkan fasilitas.';
        }

        $this->redirect('/admin/fasilitas');
    }

    public function update($id)
    {
        $data = $_POST;

        // Handle Photo Upload (optional)
        if (isset($_FILES['foto_fasilitas']) && $_FILES['foto_fasilitas']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/fasilitas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['foto_fasilitas']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['foto_fasilitas']['tmp_name'], $targetPath)) {
                // Delete old photo if exists
                $old = $this->fasilitasModel->getFacilityById($id);
                if ($old && !empty($old['foto_fasilitas']) && file_exists(__DIR__ . '/../../../public/' . $old['foto_fasilitas'])) {
                    @unlink(__DIR__ . '/../../../public/' . $old['foto_fasilitas']);
                }

                $data['foto_fasilitas'] = 'uploads/fasilitas/' . $fileName;
            }
        }

        $updated = $this->fasilitasModel->updateFacility($id, $data);
        if ($updated) {
            $_SESSION['flash_success'] = 'Fasilitas berhasil diperbarui.';
        } else {
            $_SESSION['flash_error'] = 'Gagal memperbarui fasilitas.';
        }

        $this->redirect('/admin/fasilitas');
    }

    public function destroy($id)
    {
        $item = $this->fasilitasModel->getFacilityById($id);
        if ($item && !empty($item['foto_fasilitas']) && file_exists(__DIR__ . '/../../../public/' . $item['foto_fasilitas'])) {
            @unlink(__DIR__ . '/../../../public/' . $item['foto_fasilitas']);
        }

        $deleted = $this->fasilitasModel->deleteFacility($id);
        if ($deleted) {
            $_SESSION['flash_success'] = 'Fasilitas berhasil dihapus.';
        } else {
            $_SESSION['flash_error'] = 'Gagal menghapus fasilitas.';
        }

        $this->redirect('/admin/fasilitas');
    }
}
