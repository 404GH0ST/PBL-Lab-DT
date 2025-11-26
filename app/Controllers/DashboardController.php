<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Member;

class DashboardController extends Controller
{
    protected $memberModel;
    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
    }
    public function index()
    {
        $users = $this->memberModel->getAllMembers();

        $stats = [
            'users' => count($users),
            'active_sessions' => 12,
            'new_registrations' => 5,
            'reports' => 8
        ];

        return $this->view('admin/dashboard', [
            'title' => 'Dashboard - Lab Admin',
            'layout' => 'layouts/admin',
            'pageTitle' => 'Dashboard Overview',
            'stats' => $stats
        ]);
    }
}
