<?php

namespace App\Models;

use Core\Model;

class FokusRiset extends Model
{
    protected $table = 'fokus_riset';
    protected $primaryKey = 'id_fokus';

    public function getAllFocus($order = 'DESC')
    {
        $sql = "SELECT f.*, a.nama_lengkap as penulis FROM {$this->table} f LEFT JOIN anggota a ON f.id_penulis = a.id_anggota ORDER BY f.id_fokus {$order}";
        return $this->db->query($sql);
    }

    public function getApprovedFocus($order = 'DESC')
    {
        $sql = "SELECT f.*, a.nama_lengkap as penulis FROM {$this->table} f LEFT JOIN anggota a ON f.id_penulis = a.id_anggota WHERE f.status = 'approved' ORDER BY f.id_fokus {$order}";
        return $this->db->query($sql);
    }

    public function getFocusById($id)
    {
        $result = $this->db->query("SELECT f.*, a.nama_lengkap as penulis FROM {$this->table} f LEFT JOIN anggota a ON f.id_penulis = a.id_anggota WHERE f.id_fokus = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createFocus($data)
    {
        $sql = "INSERT INTO {$this->table} (bidang, id_penulis, status) VALUES (:bidang, :id_penulis, :status)";
        return $this->db->execute($sql, [
            'bidang' => $data['bidang'],
            'id_penulis' => $data['id_penulis'] ?? null,
            'status' => $data['status'] ?? 'pending'
        ]);
    }

    public function updateFocus($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['bidang'])) {
            $fields[] = "bidang = :bidang";
            $params['bidang'] = $data['bidang'];
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

        if (empty($fields)) {
            return false;
        }

        $fields[] = "updated_at = CURRENT_TIMESTAMP";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_fokus = :id";
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
        $sql = "SELECT f.*, a.nama_lengkap as penulis FROM {$this->table} f LEFT JOIN anggota a ON f.id_penulis = a.id_anggota ORDER BY f.id_fokus DESC LIMIT :limit OFFSET :offset";
        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }
}
