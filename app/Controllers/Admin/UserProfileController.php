<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Member;

class UserProfileController extends Controller
{
    private $memberModel;

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return $this->redirect('/login');
        }

        $user = $this->memberModel->getMemberById($userId);

        if (!$user) {
            return $this->redirect('/logout');
        }

        return $this->view('admin/user_profile/index', [
            'user' => $user,
            'pageTitle' => 'Profil Saya',
            'layout' => 'layouts/admin'
        ]);
    }

    public function update()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return $this->redirect('/login');
        }

        $data = $_POST;
        $files = $_FILES;

        // Validation
        if (empty($data['nama_lengkap']) || empty($data['email'])) {
            $this->redirect('/admin/my-profile?error=required_fields');
            return;
        }

        $updateData = [
            'nama_lengkap' => $data['nama_lengkap'],
            'email' => $data['email'],
            'nip_nim' => $data['nip_nim'] ?? null,
            'bio' => $data['bio'] ?? null
        ];

        // Handle Password Update
        if (!empty($data['password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                $_SESSION['flash_error'] = 'Konfirmasi kata sandi tidak cocok.';
                $this->redirect('/admin/my-profile');
                return;
            }
            $updateData['password'] = $data['password'];
        }

        // Handle File Upload (Profile Photo)
        if (isset($files['foto_profil']) && $files['foto_profil']['error'] === UPLOAD_ERR_OK) {
            // Check file size (2MB limit)
            if ($files['foto_profil']['size'] > 2 * 1024 * 1024) {
                $_SESSION['flash_error'] = 'Ukuran file terlalu besar. Maksimal 2MB.';
                $this->redirect('/admin/my-profile');
                return;
            }

            $uploadDir = 'uploads/foto_profil/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Get file extension
            $extension = pathinfo($files['foto_profil']['name'], PATHINFO_EXTENSION);
            $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($files['foto_profil']['tmp_name'], $targetPath)) {
                $updateData['foto_profil'] = $filename;

                // Delete old photo if exists (optional cleanup)
                // $oldUser = $this->memberModel->getMemberById($userId);
                // if ($oldUser['foto_profil'] && file_exists($uploadDir . $oldUser['foto_profil'])) {
                //     unlink($uploadDir . $oldUser['foto_profil']);
                // }
            }
        }

        // Update in Database
        if ($this->memberModel->updateMember($userId, $updateData)) {
            // Update Session Data
            $_SESSION['user']['nama_lengkap'] = $updateData['nama_lengkap'];
            $_SESSION['user']['email'] = $updateData['email'];
            $_SESSION['user']['nip_nim'] = $updateData['nip_nim'];
            if (isset($updateData['foto_profil'])) {
                $_SESSION['user']['foto_profil'] = $updateData['foto_profil'];
            }

            $_SESSION['flash_success'] = 'Profil berhasil diperbarui.';
            $this->redirect('/admin/my-profile');
        } else {
            $_SESSION['flash_error'] = 'Terjadi kesalahan saat memperbarui profil.';
            $this->redirect('/admin/my-profile');
        }
    }
}
