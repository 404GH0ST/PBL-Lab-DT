<?php

namespace App\Models;

use Core\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';

    public function getRecentActivities($limit = 10)
    {
        $sql = "
            SELECT 
                al.*,
                COALESCE(a.nama_lengkap, 'System') as user_name,
                a.foto_profil
            FROM activity_logs al
            LEFT JOIN anggota a ON al.user_id = a.id_anggota
            ORDER BY al.created_at DESC
            LIMIT :limit
        ";

        return $this->db->query($sql, ['limit' => $limit]);
    }

    public function log($userId, $actionType, $module, $resourceId, $resourceName, $metaData = [])
    {
        $data = [
            'user_id' => $userId,
            'action_type' => $actionType,
            'module' => $module,
            'resource_id' => $resourceId,
            'resource_name' => $resourceName,
            'meta_data' => json_encode($metaData)
        ];

        $sql = "INSERT INTO {$this->table} (user_id, action_type, module, resource_id, resource_name, meta_data) VALUES (:user_id, :action_type, :module, :resource_id, :resource_name, :meta_data)";
        return $this->db->execute($sql, $data);
    }
}
