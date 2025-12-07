<?php

namespace App\Models;

use Core\Model;

class VisiMisi extends Model
{
    protected $table = 'profil_lab';
    protected $primaryKey = 'id';

    public function getAllVisiMisi()
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE jenis_konten IN ('visi', 'misi') ORDER BY jenis_konten DESC");
    }

    public function getByType($type)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE jenis_konten = :type", ['type' => $type]);
        return $result[0] ?? null;
    }

    public function getVisi()
    {
        return $this->getByType('visi');
    }

    public function getMisi()
    {
        return $this->getByType('misi');
    }

    public function getApprovedByType($type)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE jenis_konten = :type AND status = 'approved'", ['type' => $type]);
        return $result[0] ?? null;
    }

    public function createVisiMisi($data)
    {
        $sql = "INSERT INTO {$this->table} (jenis_konten, isi_konten, id_editor, status, updated_at) 
                VALUES (:jenis_konten, :isi_konten, :id_editor, :status, CURRENT_TIMESTAMP)";

        return $this->db->execute($sql, [
            'jenis_konten' => $data['jenis_konten'],
            'isi_konten' => $data['isi_konten'],
            'id_editor' => $data['id_editor'] ?? null,
            'status' => $data['status'] ?? 'pending'
        ]);
    }

    public function updateVisiMisi($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['isi_konten'])) {
            $fields[] = "isi_konten = :isi_konten";
            $params['isi_konten'] = $data['isi_konten'];
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
        if (isset($data['id_editor'])) {
            $fields[] = "id_editor = :id_editor";
            $params['id_editor'] = $data['id_editor'];
        }

        $fields[] = "updated_at = CURRENT_TIMESTAMP";

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        return $this->db->execute($sql, $params);
    }

    public function deleteVisiMisi($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = :id", ['id' => $id]);
    }

    public function upsertVisiMisi($type, $content, $extraMap = [])
    {
        $existing = $this->getByType($type);

        $data = array_merge(['isi_konten' => $content], $extraMap);

        if ($existing) {
            return $this->updateVisiMisi($existing['id'], $data);
        } else {
            $data['jenis_konten'] = $type;
            return $this->createVisiMisi($data);
        }
    }
}
