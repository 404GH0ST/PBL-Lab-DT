<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Course;
use App\Models\Member;

class CourseController extends Controller
{
    private $courseModel;
    private $memberModel;

    public function __construct()
    {
        $this->courseModel = $this->loadModel(Course::class);
        $this->memberModel = $this->loadModel(Member::class);
    }

    public function index()
    {
        $courses = $this->courseModel->getAllCourses();
        $members = $this->memberModel->getAllMembers();
        return $this->view('admin/courses/index', [
            'title' => 'Manajemen Perkuliahan',
            'courses' => $courses,
            'members' => $members,
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = [
            'judul_perkuliahan' => $_POST['judul_perkuliahan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar'] ?? 'bi bi-book',
            'id_penulis' => $_POST['id_penulis'] ?? $_SESSION['user']['id']
        ];

        if ($this->courseModel->createCourse($data)) {
            $_SESSION['flash_success'] = 'Perkuliahan berhasil ditambahkan.';
            header('Location: /admin/courses');
            exit;
        }
    }

    public function update($id)
    {
        $data = [
            'judul_perkuliahan' => $_POST['judul_perkuliahan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar'],
            'id_penulis' => $_POST['id_penulis'] ?? $_SESSION['user']['id']
        ];

        if ($this->courseModel->updateCourse($id, $data)) {
            $_SESSION['flash_success'] = 'Perkuliahan berhasil diperbarui.';
            header('Location: /admin/courses');
            exit;
        }
    }

    public function destroy($id)
    {
        $this->courseModel->deleteCourse($id);
        $_SESSION['flash_success'] = 'Perkuliahan berhasil dihapus.';
        header('Location: /admin/courses');
        exit;
    }
}
