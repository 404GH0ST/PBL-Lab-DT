<?php

namespace App\Models;

use Core\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    public function getAllFacilities()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_fasilitas DESC";
        return $this->db->query($sql);
    }

    public function countAllFacilities()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedFacilities($limit, $offset)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id_fasilitas DESC LIMIT :limit OFFSET :offset";
        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    public function countApprovedFacilities()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'approved'";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedApprovedFacilities($limit, $offset)
    {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'approved' ORDER BY id_fasilitas DESC LIMIT :limit OFFSET :offset";
        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    public function getFacilityById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_fasilitas = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createFacility($data)
    {
        $sql = "INSERT INTO {$this->table} (nama_fasilitas, deskripsi, foto_fasilitas, jumlah_unit, kondisi)
                VALUES (:nama_fasilitas, :deskripsi, :foto_fasilitas, :jumlah_unit, :kondisi)";

        return $this->db->execute($sql, [
            'nama_fasilitas' => $data['nama_fasilitas'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'foto_fasilitas' => $data['foto_fasilitas'] ?? null,
            'jumlah_unit' => $data['jumlah_unit'] ?? 1,
            'kondisi' => $data['kondisi'] ?? 'baik'
        ]);
    }

    public function updateFacility($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['nama_fasilitas'])) {
            $fields[] = 'nama_fasilitas = :nama_fasilitas';
            $params['nama_fasilitas'] = $data['nama_fasilitas'];
        }
        if (isset($data['deskripsi'])) {
            $fields[] = 'deskripsi = :deskripsi';
            $params['deskripsi'] = $data['deskripsi'];
        }
        if (isset($data['foto_fasilitas'])) {
            $fields[] = 'foto_fasilitas = :foto_fasilitas';
            $params['foto_fasilitas'] = $data['foto_fasilitas'];
        }
        if (isset($data['jumlah_unit'])) {
            $fields[] = 'jumlah_unit = :jumlah_unit';
            $params['jumlah_unit'] = $data['jumlah_unit'];
        }
        if (isset($data['kondisi'])) {
            $fields[] = 'kondisi = :kondisi';
            $params['kondisi'] = $data['kondisi'];
        }
        if (isset($data['status'])) {
            $fields[] = 'status = :status';
            $params['status'] = $data['status'];
        }
        if (isset($data['id_admin_penilai'])) {
            $fields[] = 'id_admin_penilai = :id_admin_penilai';
            $params['id_admin_penilai'] = $data['id_admin_penilai'];
        }
        if (isset($data['catatan_admin'])) {
            $fields[] = 'catatan_admin = :catatan_admin';
            $params['catatan_admin'] = $data['catatan_admin'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_fasilitas = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteFacility($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_fasilitas = :id", ['id' => $id]);
    }
}
