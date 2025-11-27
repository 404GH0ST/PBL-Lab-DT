<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Publication;
use App\Models\Member;


class PublicationController extends Controller
{
    protected $publicationModel;
    protected $memberModel;

    public function __construct()
    {
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $publications = $this->publicationModel->getAllPublications();
        $members = $this->memberModel->getAllMembers(); // For the "Author" dropdown in modal

        return $this->view('admin/publications/index', [
            'publications' => $publications,
            'members' => $members,
            'pageTitle' => 'Publications Management',
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = $_POST;

        // In a real app, id_anggota might come from session if not admin
        // For admin, we allow selecting the author

        // Restrict operators from setting status
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $data['status'] = 'pending';
        }

        $this->publicationModel->createPublication($data);
        $this->redirect('/admin/publications');
    }

    public function update($id)
    {
        $data = $_POST;

        // Restrict operators from changing status, and reset to pending on edit
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $data['status'] = 'pending';
        }

        $this->publicationModel->updatePublication($id, $data);
        $this->redirect('/admin/publications');
    }

    public function destroy($id)
    {
        $this->publicationModel->deletePublication($id);
        $this->redirect('/admin/publications');
    }
}
