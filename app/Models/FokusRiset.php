<?php

namespace App\Models;

use Core\Model;

class FokusRiset extends Model
{
    protected $table = 'fokus_riset';
    protected $primaryKey = 'id_fokus';

    public function getAllFocus($order = 'DESC')
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_fokus {$order}";
        return $this->db->query($sql);
    }

    public function getFocusById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_fokus = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createFocus($data)
    {
        $sql = "INSERT INTO {$this->table} (bidang) VALUES (:bidang)";
        return $this->db->execute($sql, [
            'bidang' => $data['bidang']
        ]);
    }

    public function updateFocus($id, $data)
    {
        $params = ['id' => $id, 'bidang' => $data['bidang']];

        $sql = "UPDATE {$this->table} SET bidang = :bidang WHERE id_fokus = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteFocus($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_fokus = :id", ['id' => $id]);
    }

    public function countAllFocus()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedFocus($limit, $offset)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_fokus DESC LIMIT :limit OFFSET :offset";
        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }
}
