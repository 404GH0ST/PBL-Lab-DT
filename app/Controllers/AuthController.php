<?php

namespace App\Controllers;

use App\Models\Member;
use Core\Controller;


class AuthController extends Controller
{
    protected $memberModel;
    protected $errors = [];

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
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
            $this->errors['login'] = 'Username and password are required';
        } else {
            $user = $this->memberModel->authenticate($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                return $this->redirect('/admin/dashboard');
            }
            $this->errors['login'] = 'Invalid username or password';
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
