<?php

namespace App\Models;

use Core\Model;

class Contact extends Model
{
    protected $table = 'info_lab';
    protected $primaryKey = 'id';

    public function getContactInfo()
    {
        $result = $this->db->query("SELECT * FROM {$this->table} LIMIT 1");
        return $result[0] ?? null;
    }

    public function getApprovedContactInfo()
    {
        $result = $this->db->query("SELECT * FROM {$this->table} WHERE status = 'approved' LIMIT 1");
        return $result[0] ?? null;
    }

    public function updateContactInfo($data)
    {
        $info = $this->getContactInfo();

        if ($info) {
            $fields = [];
            $params = ['id' => $info['id']];

            if (isset($data['nama_lab'])) {
                $fields[] = "nama_lab = :nama_lab";
                $params['nama_lab'] = $data['nama_lab'];
            }
            if (isset($data['alamat'])) {
                $fields[] = "alamat = :alamat";
                $params['alamat'] = $data['alamat'];
            }
            if (isset($data['email'])) {
                $fields[] = "email = :email";
                $params['email'] = $data['email'];
            }
            if (isset($data['telepon'])) {
                $fields[] = "telepon = :telepon";
                $params['telepon'] = $data['telepon'];
            }
            if (isset($data['link_maps'])) {
                $fields[] = "link_maps = :link_maps";
                $params['link_maps'] = $data['link_maps'];
            }
            if (isset($data['link_instagram'])) {
                $fields[] = "link_instagram = :link_instagram";
                $params['link_instagram'] = $data['link_instagram'];
            }
            if (isset($data['link_youtube'])) {
                $fields[] = "link_youtube = :link_youtube";
                $params['link_youtube'] = $data['link_youtube'];
            }
            if (isset($data['link_linkedin'])) {
                $fields[] = "link_linkedin = :link_linkedin";
                $params['link_linkedin'] = $data['link_linkedin'];
            }
            if (isset($data['link_facebook'])) {
                $fields[] = "link_facebook = :link_facebook";
                $params['link_facebook'] = $data['link_facebook'];
            }
            if (isset($data['link_twitter'])) {
                $fields[] = "link_twitter = :link_twitter";
                $params['link_twitter'] = $data['link_twitter'];
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
            if (isset($data['id_editor'])) {
                $fields[] = "id_editor = :id_editor";
                $params['id_editor'] = $data['id_editor'];
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            return $this->db->execute($sql, $params);
        } else {
            $sql = "INSERT INTO {$this->table} (nama_lab, alamat, email, telepon, link_maps, link_instagram, link_youtube, link_linkedin, link_facebook, link_twitter, deskripsi, id_editor, status, updated_at) 
                    VALUES (:nama_lab, :alamat, :email, :telepon, :link_maps, :link_instagram, :link_youtube, :link_linkedin, :link_facebook, :link_twitter, :deskripsi, :id_editor, :status, CURRENT_TIMESTAMP)";

            return $this->db->execute($sql, [
                'nama_lab' => $data['nama_lab'] ?? 'Lab DT',
                'alamat' => $data['alamat'] ?? '',
                'email' => $data['email'] ?? '',
                'telepon' => $data['telepon'] ?? '',
                'link_maps' => $data['link_maps'] ?? '',
                'link_instagram' => $data['link_instagram'] ?? '',
                'link_youtube' => $data['link_youtube'] ?? '',
                'link_linkedin' => $data['link_linkedin'] ?? '',
                'link_facebook' => $data['link_facebook'] ?? '',
                'link_twitter' => $data['link_twitter'] ?? '',
                'deskripsi' => $data['deskripsi'] ?? '',
                'id_editor' => $data['id_editor'] ?? null,
                'status' => $data['status'] ?? 'pending'
            ]);
        }
    }
}
