<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Member;


class MemberController extends Controller
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $members = $this->memberModel->getAllMembers();
        return $this->view('admin/members/index', ['members' => $members, 'pageTitle' => 'Members Management', 'layout' => 'layouts/admin']);
    }

    public function store()
    {
        $data = $_POST;

        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['foto_profil']['tmp_name'];
            $name = basename($_FILES['foto_profil']['name']);
            $destination = __DIR__ . '/../../../public/uploads/foto_profil/' . $name;

            // Ensure directory exists
            if (!is_dir(dirname($destination))) {
                mkdir(dirname($destination), 0755, true);
            }

            if (move_uploaded_file($tmp_name, $destination)) {
                $data['foto_profil'] = $name;
            }
        }

        $this->memberModel->createMember($data);
        $this->redirect('/admin/members');
    }

    public function update($id)
    {
        $data = $_POST;
        // Handle file upload for update if needed (similar to store)

        $this->memberModel->updateMember($id, $data);
        $this->redirect('/admin/members');
    }

    public function destroy($id)
    {
        $this->memberModel->deleteMember($id);
        $this->redirect('/admin/members');
    }
}
