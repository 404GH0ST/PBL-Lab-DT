<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = $this->loadModel(Course::class);
    }

    public function index()
    {
        $courses = $this->courseModel->getAllCourses();
        return $this->view('admin/courses/index', [
            'title' => 'Manajemen Perkuliahan',
            'courses' => $courses,
            'layout' => 'layouts/admin'
        ]);
    }

    public function store()
    {
        $data = [
            'judul_perkuliahan' => $_POST['judul_perkuliahan'],
            'deskripsi' => $_POST['deskripsi'],
            'gambar' => $_POST['gambar'] ?? 'bi bi-book' // Default icon if not provided
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
            'gambar' => $_POST['gambar']
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
