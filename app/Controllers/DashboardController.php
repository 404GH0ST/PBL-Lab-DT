<?php

namespace App\Controllers;

use App\Models\Member;
use Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Refresh stats (using Stored Procedure)
        // Note: In a real high-traffic app, this might be done via cron or background job
        $this->db()->execute("CALL refresh_dashboard_stats()");

        // Fetch stats (using Materialized View)
        $statsResult = $this->db()->query("SELECT * FROM mv_dashboard_stats");
        $stats = $statsResult[0] ?? [
            'total_users' => 0,
            'total_news' => 0,
            'total_gallery' => 0,
            'total_publications' => 0,
            'total_activities' => 0,
            'total_courses' => 0,
            'total_research' => 0,
            'pending_approvals' => 0
        ];

        // Map stats to view expected keys
        $viewStats = [
            'users' => $stats['total_users'],
            'news' => $stats['total_news'],
            'gallery' => $stats['total_gallery'],
            'publications' => $stats['total_publications'],
            'activities' => $stats['total_activities'],
            'courses' => $stats['total_courses'],
            'research' => $stats['total_research'],
            'pending_approvals' => $stats['pending_approvals']
        ];

        // Customize for Operator
        $currentUser = session('user');
        if (isset($currentUser['role']) && $currentUser['role'] === 'operator') {
            try {
                $opStatsResult = $this->db()->query("SELECT * FROM get_operator_stats(:id)", ['id' => $currentUser['id']]);
                $opStats = $opStatsResult[0] ?? ['my_contributions' => 0, 'my_pending' => 0];

                // Overwrite keys to pass to view (View will handle label changes based on role)
                $viewStats['users'] = $opStats['my_contributions'];
                $viewStats['pending_approvals'] = $opStats['my_pending'];
            } catch (\Exception $e) {
                // Fallback
            }
        }

        // Fetch Recent Activity (using ActivityLog View and Pagination)
        $activityLogModel = new \App\Models\ActivityLog($this->db());

        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $totalLogs = $activityLogModel->countAllLogs();
        $pagination = new \Core\Pagination($totalLogs, $limit, $page);

        $logs = $activityLogModel->getPaginatedLogs($limit, $pagination->getOffset());

        $recentActivity = array_map(function ($log) {
            // Map Action Type to Human Readable Action
            $actionMap = [
                'create' => [
                    'Berita' => 'Memposting Berita',
                    'Galeri' => 'Mengunggah Foto',
                    'default' => 'Menambahkan ' . $log['module']
                ],
                'update' => 'Memperbarui ' . $log['module'],
                'approve' => 'Menyetujui ' . $log['module'],
                'reject' => 'Menolak ' . $log['module'],
                'delete' => 'Menghapus ' . $log['module']
            ];

            $action = '';
            if ($log['action_type'] === 'create') {
                $action = $actionMap['create'][$log['module']] ?? $actionMap['create']['default'];
            } else {
                $action = $actionMap[$log['action_type']] ?? $log['action_type'];
            }

            // Map keys to View expectations
            return [
                'user_name' => $log['user_name'],
                'foto_profil' => $log['foto_profil'],
                'action' => $action,
                'module' => $log['module'],
                'title' => $log['resource_name'],
                'activity_time' => $log['created_at'],
                'status' => match ($log['action_type']) {
                    'create', 'update' => 'pending',
                    'approve' => 'approved',
                    'reject' => 'rejected',
                    default => 'info'
                }
            ];
        }, $logs);

        // Fetch Top Contributors (using View)
        $topContributors = $this->db()->query("SELECT * FROM view_top_contributors");

        return $this->view('admin/dashboard', [
            'title' => 'Dashboard - Lab Admin',
            'layout' => 'layouts/admin',
            'pageTitle' => 'Ringkasan Dashboard',
            'stats' => $viewStats,
            'recentActivity' => $recentActivity,
            'topContributors' => $topContributors,
            'pagination' => $pagination,
            'baseUrl' => '/admin/dashboard'
        ]);
    }
}
