<?php

namespace App\Controllers;

use App\Models\Member;
use Core\Controller;
use Core\Http\Request;

class AuthController extends Controller
{
    protected $memberModel;

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

    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = $this->memberModel->authenticate($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            return $this->redirect('/admin/dashboard');
        } else {
            return $this->view('auth/login', [
                'title' => 'Login - Lab Informatika',
                'layout' => 'layouts/auth',
                'error' => 'Invalid username or password'
            ]);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return $this->redirect('/');
    }
}
