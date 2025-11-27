<?php

namespace App\Models;

use Core\Model;

class Publication extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id_publikasi';

    public function getAllPublications()
    {
        $sql = "SELECT p.*, a.nama_lengkap as nama_penulis 
                FROM {$this->table} p
                JOIN anggota a ON p.id_anggota = a.id_anggota
                ORDER BY p.tahun_terbit DESC, p.id_publikasi DESC";
        return $this->db->query($sql);
    }

    public function getApprovedPublications()
    {
        $sql = "SELECT p.*, a.nama_lengkap as nama_penulis 
                FROM {$this->table} p
                JOIN anggota a ON p.id_anggota = a.id_anggota
                WHERE p.status = 'approved'
                ORDER BY p.tahun_terbit DESC, p.id_publikasi DESC";
        return $this->db->query($sql);
    }

    public function getPublicationById($id)
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE id_publikasi = :id", ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createPublication($data)
    {
        $sql = "INSERT INTO {$this->table} (judul_publikasi, jenis_publikasi, tahun_terbit, link_publikasi, deskripsi, id_anggota, status) 
                VALUES (:judul_publikasi, :jenis_publikasi, :tahun_terbit, :link_publikasi, :deskripsi, :id_anggota, :status)";

        return $this->db->execute($sql, [
            'judul_publikasi' => $data['judul_publikasi'],
            'jenis_publikasi' => $data['jenis_publikasi'],
            'tahun_terbit' => $data['tahun_terbit'],
            'link_publikasi' => $data['link_publikasi'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'id_anggota' => $data['id_anggota'], // Assuming this comes from session or form
            'status' => $data['status'] ?? 'pending'
        ]);
    }

    public function updatePublication($id, $data)
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['judul_publikasi'])) {
            $fields[] = "judul_publikasi = :judul_publikasi";
            $params['judul_publikasi'] = $data['judul_publikasi'];
        }
        if (isset($data['jenis_publikasi'])) {
            $fields[] = "jenis_publikasi = :jenis_publikasi";
            $params['jenis_publikasi'] = $data['jenis_publikasi'];
        }
        if (isset($data['tahun_terbit'])) {
            $fields[] = "tahun_terbit = :tahun_terbit";
            $params['tahun_terbit'] = $data['tahun_terbit'];
        }
        if (isset($data['link_publikasi'])) {
            $fields[] = "link_publikasi = :link_publikasi";
            $params['link_publikasi'] = $data['link_publikasi'];
        }
        if (isset($data['deskripsi'])) {
            $fields[] = "deskripsi = :deskripsi";
            $params['deskripsi'] = $data['deskripsi'];
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

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_publikasi = :id";
        return $this->db->execute($sql, $params);
    }

    public function deletePublication($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id_publikasi = :id", ['id' => $id]);
    }
}
