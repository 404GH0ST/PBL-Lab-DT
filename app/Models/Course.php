<?php

namespace App\Models;

use Core\Model;

class Course extends Model
{
    protected $table = 'perkuliahan';
    protected $primaryKey = 'id_perkuliahan';

    public function getAllCourses()
    {
        return $this->db->query("SELECT p.*, a.nama_lengkap as penulis FROM {$this->table} p LEFT JOIN anggota a ON p.id_penulis = a.id_anggota ORDER BY p.id_perkuliahan ASC");
    }

    public function getAllApprovedCourses()
    {
        return $this->db->query("SELECT p.*, a.nama_lengkap as penulis FROM {$this->table} p LEFT JOIN anggota a ON p.id_penulis = a.id_anggota WHERE p.status = 'approved' ORDER BY p.id_perkuliahan ASC");
    }

    public function getCourseById($id)
    {
        $result = $this->db->query("SELECT p.*, a.nama_lengkap as penulis FROM {$this->table} p LEFT JOIN anggota a ON p.id_penulis = a.id_anggota WHERE p.id_perkuliahan = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createCourse($data)
    {
        $sql = "INSERT INTO {$this->table} (judul_perkuliahan, deskripsi, gambar, id_penulis) VALUES (:judul, :deskripsi, :gambar, :id_penulis)";
        return $this->db->execute($sql, [
            'judul' => $data['judul_perkuliahan'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? null,
            'id_penulis' => $data['id_penulis'] ?? null
        ]);
    }

    public function updateCourse($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['judul_perkuliahan'])) {
            $fields[] = "judul_perkuliahan = :judul";
            $params['judul'] = $data['judul_perkuliahan'];
        }
        if (isset($data['deskripsi'])) {
            $fields[] = "deskripsi = :deskripsi";
            $params['deskripsi'] = $data['deskripsi'];
        }
        if (isset($data['gambar'])) {
            $fields[] = "gambar = :gambar";
            $params['gambar'] = $data['gambar'];
        }
        if (isset($data['id_penulis'])) {
            $fields[] = "id_penulis = :id_penulis";
            $params['id_penulis'] = $data['id_penulis'];
        }
        if (isset($data['status'])) {
            $fields[] = "status = :status";
            $params['status'] = $data['status'];
        }
        if (isset($data['id_admin_penilai'])) {
            $fields[] = "id_admin_penilai = :id_admin_penilai";
            $params['id_admin_penilai'] = $data['id_admin_penilai'];
        }
        if (isset($data['catatan_admin'])) {
            $fields[] = "catatan_admin = :catatan_admin";
            $params['catatan_admin'] = $data['catatan_admin'];
        }

        $fields[] = "updated_at = CURRENT_TIMESTAMP";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_perkuliahan = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteCourse($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_perkuliahan = :id", ['id' => $id]);
    }
}
