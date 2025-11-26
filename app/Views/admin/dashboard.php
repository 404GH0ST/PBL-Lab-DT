<div class="row g-4 mb-4">
    <!-- Stats Cards -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted mb-0">Total Users</h6>
                    <div class="p-2 bg-primary bg-opacity-10 rounded-circle">
                        <i class="bi bi-people text-primary"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['users'] ?? 0 ?></h3>
                <small class="text-success fw-medium">
                    <i class="bi bi-arrow-up-short"></i> 12% increase
                </small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted mb-0">Active Sessions</h6>
                    <div class="p-2 bg-success bg-opacity-10 rounded-circle">
                        <i class="bi bi-activity text-success"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['active_sessions'] ?? 0 ?></h3>
                <small class="text-success fw-medium">
                    <i class="bi bi-arrow-up-short"></i> 4% increase
                </small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted mb-0">New Registrations</h6>
                    <div class="p-2 bg-warning bg-opacity-10 rounded-circle">
                        <i class="bi bi-person-plus text-warning"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['new_registrations'] ?? 0 ?></h3>
                <small class="text-danger fw-medium">
                    <i class="bi bi-arrow-down-short"></i> 2% decrease
                </small>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="text-muted mb-0">Pending Reports</h6>
                    <div class="p-2 bg-danger bg-opacity-10 rounded-circle">
                        <i class="bi bi-flag text-danger"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1"><?= $stats['reports'] ?? 0 ?></h3>
                <small class="text-muted fw-medium">
                    Same as yesterday
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Charts -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="card-title mb-1 fw-bold">Recent Activity</h5>
                    <p class="text-muted small mb-0">Latest system events and updates</p>
                </div>
                <button class="btn btn-sm btn-light text-primary">View All</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">User
                                </th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action
                                </th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Module
                                </th>
                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Time</th>
                                <th
                                    class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar bg-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">JD</div>
                                        <span class="fw-bold text-dark">John Doe</span>
                                    </div>
                                </td>
                                <td>Created new user</td>
                                <td><span class="badge bg-light text-dark border">User Management</span></td>
                                <td class="text-secondary text-sm">2 mins ago</td>
                                <td class="text-end pe-4"><span
                                        class="badge bg-success-subtle text-success">Success</span></td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar bg-light text-info rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">AS</div>
                                        <span class="fw-bold text-dark">Alice Smith</span>
                                    </div>
                                </td>
                                <td>Updated schedule</td>
                                <td><span class="badge bg-light text-dark border">Schedules</span></td>
                                <td class="text-secondary text-sm">1 hour ago</td>
                                <td class="text-end pe-4"><span
                                        class="badge bg-warning-subtle text-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar bg-light text-warning rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">RJ</div>
                                        <span class="fw-bold text-dark">Robert Johnson</span>
                                    </div>
                                </td>
                                <td>Deleted record</td>
                                <td><span class="badge bg-light text-dark border">Inventory</span></td>
                                <td class="text-secondary text-sm">3 hours ago</td>
                                <td class="text-end pe-4"><span class="badge bg-danger-subtle text-danger">Failed</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar bg-light text-success rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">MK</div>
                                        <span class="fw-bold text-dark">Maria K.</span>
                                    </div>
                                </td>
                                <td>Login attempt</td>
                                <td><span class="badge bg-light text-dark border">Auth</span></td>
                                <td class="text-secondary text-sm">5 hours ago</td>
                                <td class="text-end pe-4"><span
                                        class="badge bg-success-subtle text-success">Success</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 fw-bold">System Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-medium">Server Load</span>
                        <span class="text-primary">45%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar" role="progressbar" style="width: 45%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-medium">Memory Usage</span>
                        <span class="text-warning">70%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 70%"></div>
                    </div>
                </div>
                <div class="mb-0">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-medium">Storage</span>
                        <span class="text-success">25%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>