<?php

namespace App\Models;

use Core\Model;

class Course extends Model
{
    protected $table = 'perkuliahan';
    protected $primaryKey = 'id_perkuliahan';

    public function getAllCourses()
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id_perkuliahan ASC");
    }

    public function getCourseById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_perkuliahan = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createCourse($data)
    {
        $sql = "INSERT INTO {$this->table} (judul_perkuliahan, deskripsi, gambar) VALUES (:judul, :deskripsi, :gambar)";
        return $this->db->execute($sql, [
            'judul' => $data['judul_perkuliahan'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? null
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

        $fields[] = "updated_at = CURRENT_TIMESTAMP";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_perkuliahan = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteCourse($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_perkuliahan = :id", ['id' => $id]);
    }
}
