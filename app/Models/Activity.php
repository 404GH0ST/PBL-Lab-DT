<?php

namespace App\Models;

use Core\Model;

class Activity extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    public function getAllActivities()
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY id_kegiatan ASC");
    }

    public function getActivityById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_kegiatan = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createActivity($data)
    {
        $sql = "INSERT INTO {$this->table} (judul_kegiatan, deskripsi, gambar) VALUES (:judul, :deskripsi, :gambar)";
        return $this->db->execute($sql, [
            'judul' => $data['judul_kegiatan'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? null
        ]);
    }

    public function updateActivity($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['judul_kegiatan'])) {
            $fields[] = "judul_kegiatan = :judul";
            $params['judul'] = $data['judul_kegiatan'];
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

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_kegiatan = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteActivity($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_kegiatan = :id", ['id' => $id]);
    }
}
