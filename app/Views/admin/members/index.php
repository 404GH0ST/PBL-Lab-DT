<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark">Members List</h5>
            <p class="text-muted small mb-0">Manage lab members and their roles</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addMemberModal">
            <i class="bi bi-plus-lg"></i>
            <span>Add Member</span>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Member</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">NIP/NIM</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Role</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($members)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-people display-4 mb-3 opacity-50"></i>
                                    <p class="mb-0">No members found</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar">
                                            <?= strtoupper(substr($member['nama_lengkap'], 0, 1)) ?>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold text-dark"><?= htmlspecialchars($member['nama_lengkap']) ?></span>
                                            <span
                                                class="text-xs text-muted">@<?= htmlspecialchars($member['username']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="text-secondary text-sm"><?= htmlspecialchars($member['nip_nim'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= ucfirst($member['role']) ?></span>
                                </td>
                                <td>
                                    <?php if ($member['status_aktif']): ?>
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editMember(<?= $member['id_anggota'] ?>, '<?= htmlspecialchars($member['nama_lengkap']) ?>', '<?= htmlspecialchars($member['username']) ?>', '<?= htmlspecialchars($member['nip_nim'] ?? '') ?>', '<?= $member['role'] ?>', <?= $member['status_aktif'] ? 'true' : 'false' ?>)"
                                            data-bs-toggle="modal" data-bs-target="#editMemberModal" title="Edit Member">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-danger ms-1"
                                            onclick="confirmDelete(<?= $member['id_anggota'] ?>)" title="Delete Member">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="deleteForm-<?= $member['id_anggota'] ?>"
                                        action="/admin/members/<?= $member['id_anggota'] ?>/delete" method="POST"
                                        class="d-none"></form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/members" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-person text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="nama_lengkap"
                                name="nama_lengkap" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-at text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="username" name="username"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nip_nim" class="form-label">NIP / NIM</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-card-heading text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="nip_nim" name="nip_nim">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="password"
                                name="password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Create Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMemberForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-person text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="edit_nama_lengkap"
                                name="nama_lengkap" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-at text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="edit_username"
                                name="username" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nip_nim" class="form-label">NIP / NIM</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-card-heading text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="edit_nip_nim"
                                name="nip_nim">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role</label>
                        <select class="form-select" id="edit_role" name="role">
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status_aktif" class="form-label">Status</label>
                        <select class="form-select" id="edit_status_aktif" name="status_aktif">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="edit_password"
                                name="password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editMember(id, nama, username, nip, role, status) {
        document.getElementById('editMemberForm').action = '/admin/members/' + id + '/update';
        document.getElementById('edit_nama_lengkap').value = nama;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_nip_nim').value = nip;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_status_aktif').value = status ? '1' : '0';
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this member? This action cannot be undone.')) {
            document.getElementById('deleteForm-' + id).submit();
        }
    }
</script>