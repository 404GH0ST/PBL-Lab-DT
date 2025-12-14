<?php

namespace App\Models;

use Core\Model;

class Activity extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    public function getAllActivities()
    {
        return $this->db->query("SELECT k.*, a.nama_lengkap as penulis, a.foto_profil FROM {$this->table} k LEFT JOIN anggota a ON k.id_penulis = a.id_anggota ORDER BY k.id_kegiatan ASC");
    }

    public function getAllApprovedActivities()
    {
        return $this->db->query("SELECT k.*, a.nama_lengkap as penulis, a.foto_profil FROM {$this->table} k LEFT JOIN anggota a ON k.id_penulis = a.id_anggota WHERE k.status = 'approved' ORDER BY k.id_kegiatan ASC");
    }

    public function getActivityById($id)
    {
        $result = $this->db->query("SELECT k.*, a.nama_lengkap as penulis, a.foto_profil FROM {$this->table} k LEFT JOIN anggota a ON k.id_penulis = a.id_anggota WHERE k.id_kegiatan = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createActivity($data)
    {
        $sql = "INSERT INTO {$this->table} (judul_kegiatan, deskripsi, gambar, id_penulis) VALUES (:judul, :deskripsi, :gambar, :id_penulis)";
        return $this->db->execute($sql, [
            'judul' => $data['judul_kegiatan'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'] ?? null,
            'id_penulis' => $data['id_penulis'] ?? null
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

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_kegiatan = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteActivity($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_kegiatan = :id", ['id' => $id]);
    }

    public function countApprovedActivities()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'approved'");
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedApprovedActivities($limit, $offset)
    {
        return $this->db->query(
            "SELECT k.*, a.nama_lengkap as penulis, a.foto_profil 
             FROM {$this->table} k 
             LEFT JOIN anggota a ON k.id_penulis = a.id_anggota 
             WHERE k.status = 'approved' 
             ORDER BY k.id_kegiatan ASC 
             LIMIT :limit OFFSET :offset",
            ['limit' => $limit, 'offset' => $offset]
        );
    }
}
