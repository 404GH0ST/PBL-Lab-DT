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

        $this->publicationModel->createPublication($data);
        $this->redirect('/admin/publications');
    }

    public function update($id)
    {
        $data = $_POST;
        $this->publicationModel->updatePublication($id, $data);
        $this->redirect('/admin/publications');
    }

    public function destroy($id)
    {
        $this->publicationModel->deletePublication($id);
        $this->redirect('/admin/publications');
    }
}
