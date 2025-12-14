<?php

namespace App\Models;

use Core\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';

    public function getRecentActivities($limit = 10)
    {
        return $this->getPaginatedLogs($limit, 0);
    }

    public function countAllLogs()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        return $result[0]['total'] ?? 0;
    }

    public function getPaginatedLogs($limit, $offset)
    {
        $sql = "
            SELECT 
                al.*,
                COALESCE(a.nama_lengkap, 'System') as user_name,
                a.foto_profil
            FROM activity_logs al
            LEFT JOIN anggota a ON al.user_id = a.id_anggota
            ORDER BY al.created_at DESC
            LIMIT :limit OFFSET :offset
        ";

        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }

    public function log($userId, $actionType, $module, $resourceId, $resourceName)
    {
        $data = [
            'user_id' => $userId,
            'action_type' => $actionType,
            'module' => $module,
            'resource_id' => $resourceId,
            'resource_name' => $resourceName
        ];

        $sql = "INSERT INTO {$this->table} (user_id, action_type, module, resource_id, resource_name) VALUES (:user_id, :action_type, :module, :resource_id, :resource_name)";
        return $this->db->execute($sql, $data);
    }
}
