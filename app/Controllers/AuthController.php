<?php

namespace App\Controllers;

use App\Models\Member;
use Core\Controller;
use Core\Mailer;


class AuthController extends Controller
{
    protected $memberModel;
    protected $mailer;
    protected $errors = [];

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
        $this->mailer = new Mailer();
    }

    // --- Forgot Password Methods ---

    public function forgotPassword()
    {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        return $this->view('auth/forgot_password', [
            'title' => 'Lupa Password - Lab Informatika',
            'layout' => 'layouts/auth',
            'errors' => $errors
        ]);
    }

    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';

        if (empty($email)) {
            $_SESSION['errors']['email'] = 'Email wajib diisi';
            return $this->redirect('/forgot-password');
        }

        $user = $this->memberModel->findByEmail($email);

        if (!$user) {
            // Security: Don't reveal if user exists, or maybe reveal for UX? 
            // Generic message is safer.
            $_SESSION['flash_success'] = 'Jika email terdaftar, link reset password akan dikirim.';
            return $this->redirect('/forgot-password');
        }

        // Generate Token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Save Token
        $this->memberModel->setResetToken($user['id_anggota'], $token, $expiresAt);

        // Send Email
        $link = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password/" . $token;
        $this->mailer->send(
            $email,
            "Reset Password - Lab Data Tech",
            $this->templateResetEmail($user['nama_lengkap'], $link)
        );

        $_SESSION['flash_success'] = 'Link reset password telah dikirim ke email Anda.';
        return $this->redirect('/forgot-password');
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return $this->redirect('/login');
        }

        $user = $this->memberModel->findByResetToken($token);

        if (!$user) {
            $_SESSION['errors']['login'] = 'Token tidak valid atau sudah kadaluarsa.';
            return $this->redirect('/login');
        }

        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        return $this->view('auth/reset_password', [
            'title' => 'Reset Password - Lab Informatika',
            'layout' => 'layouts/auth',
            'token' => $token,
            'errors' => $errors
        ]);
    }

    public function updatePassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($password) || empty($confirmPassword)) {
            $_SESSION['errors']['password'] = 'Password wajib diisi';
            return $this->redirect('/reset-password/' . $token);
        }

        if ($password !== $confirmPassword) {
            $_SESSION['errors']['password'] = 'Konfirmasi password tidak cocok';
            return $this->redirect('/reset-password/' . $token);
        }

        $user = $this->memberModel->findByResetToken($token);

        if (!$user) {
            $_SESSION['errors']['login'] = 'Token tidak valid.';
            return $this->redirect('/login');
        }

        // Update Password
        // Note: updateMember hashes password if provided
        $this->memberModel->updateMember($user['id_anggota'], ['password' => $password]);

        // Clear Token
        $this->memberModel->clearResetToken($user['id_anggota']);

        $_SESSION['flash_success'] = 'Password berhasil diubah. Silakan login.';
        return $this->redirect('/login');
    }

    private function templateResetEmail($name, $link)
    {
        return "
        <div style='font-family: Arial, sans-serif; padding: 20px; background: #f9fafb;'>
            <div style='max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);'>
                <h2 style='color: #333;'>Reset Password</h2>
                <p>Halo <strong>$name</strong>,</p>
                <p>Anda menerima email ini karena ada permintaan reset password untuk akun Anda.</p>
                <p>Klik tombol di bawah ini untuk mereset password Anda:</p>
                <br>
                <a href='$link' style='background: #7ABA54; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Reset Password</a>
                <br><br>
                <p style='color: #777; font-size: 12px;'>Link ini akan kadaluarsa dalam 1 jam.</p>
                <p style='color: #777; font-size: 12px;'>Jika Anda tidak meminta reset password, abaikan email ini.</p>
            </div>
        </div>
        ";
    }

    public function login()
    {
        return $this->view('auth/login', [
            'title' => 'Login - Lab Informatika',
            'layout' => 'layouts/auth'
        ]);
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (empty($username) || empty($password)) {
            $this->errors['login'] = 'Username dan password wajib diisi';
        } else {
            $user = $this->memberModel->authenticate($username, $password);
            if ($user) {

                $_SESSION['user'] = [
                    'id' => $user['id_anggota'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'nip_nim' => $user['nip_nim'],
                    'foto_profil' => $user['foto_profil'],
                    'email' => $user['email'],
                    'status_aktif' => $user['status_aktif']
                ];
                return $this->redirect('/admin/dashboard');
            }
            $this->errors['login'] = 'Username atau password salah';
        }

        return $this->view('auth/login', [
            'title' => 'Login - Lab Informatika',
            'layout' => 'layouts/auth',
            'errors' => $this->errors
        ]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return $this->redirect('/');
    }
}
