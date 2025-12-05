<?php

namespace App\Models;

use Core\Model;

class FokusRiset extends Model
{
    protected $table = 'fokus_riset';
    protected $primaryKey = 'id_fokus';

    public function getAllFocus()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_fokus DESC";
        return $this->db->query($sql);
    }

    public function getFocusById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_fokus = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createFocus($data)
    {
        $sql = "INSERT INTO {$this->table} (judul, deskripsi, ikon) VALUES (:judul, :deskripsi, :ikon)";
        return $this->db->execute($sql, [
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'ikon' => $data['ikon'] ?? null
        ]);
    }

    public function updateFocus($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['judul'])) {
            $fields[] = 'judul = :judul';
            $params['judul'] = $data['judul'];
        }
        if (isset($data['deskripsi'])) {
            $fields[] = 'deskripsi = :deskripsi';
            $params['deskripsi'] = $data['deskripsi'];
        }
        if (isset($data['ikon'])) {
            $fields[] = 'ikon = :ikon';
            $params['ikon'] = $data['ikon'];
        }

        if (empty($fields)) return false;

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_fokus = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteFocus($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_fokus = :id", ['id' => $id]);
    }
}
