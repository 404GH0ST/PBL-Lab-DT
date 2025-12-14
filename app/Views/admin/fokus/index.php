<?php
// Admin - Fokus Riset Management View
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark">Manajemen Fokus Riset</h5>
            <p class="text-muted small mb-0">Kelola fokus riset laboratorium</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addFocusModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Fokus</span>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                            style="width: 50px;">No</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Bidang Riset</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Penulis</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                            style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($focus)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-lightbulb display-4 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada fokus riset.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($focus as $index => $f): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="text-secondary text-sm"><?= $index + 1 + ($pagination->getOffset()) ?></span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($f['bidang']) ?></span>
                                </td>
                                <td>
                                    <span
                                        class="text-sm text-dark fw-medium"><?= htmlspecialchars($f['penulis'] ?? 'System') ?></span>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = match ($f['status'] ?? 'pending') {
                                        'approved' => 'bg-success-subtle text-success',
                                        'rejected' => 'bg-danger-subtle text-danger',
                                        default => 'bg-warning-subtle text-warning'
                                    };
                                    $statusLabel = match ($f['status'] ?? 'pending') {
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => 'Tertunda'
                                    };
                                    ?>
                                    <span class="badge <?= $statusClass ?> border"><?= $statusLabel ?></span>
                                    <?php if (($f['status'] ?? '') === 'rejected' && !empty($f['catatan_admin'])): ?>
                                        <div class="mt-1 text-xs text-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            <?= htmlspecialchars($f['catatan_admin']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editFocus(<?= $f['id_fokus'] ?>, '<?= htmlspecialchars(addslashes($f['bidang'])) ?>', '<?= $f['id_penulis'] ?? '' ?>', '<?= $f['status'] ?? 'pending' ?>', '<?= htmlspecialchars(addslashes($f['catatan_admin'] ?? '')) ?>')"
                                            data-bs-toggle="modal" data-bs-target="#editFocusModal" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete(<?= $f['id_fokus'] ?>)" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="deleteForm-<?= $f['id_fokus'] ?>"
                                        action="/admin/fokus/<?= $f['id_fokus'] ?>/delete" method="POST" class="d-none"></form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <?php include __DIR__ . '/../../partials/pagination.php'; ?>
    </div>
</div>

<!-- Add Focus Modal -->
<div class="modal fade" id="addFocusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Fokus Riset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/fokus" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bidang Riset</label>
                        <input type="text" name="bidang" class="form-control" required
                            placeholder="Contoh: Machine Learning">
                    </div>
                    <div class="mb-3">
                        <label for="id_penulis" class="form-label">Penulis</label>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'operator'): ?>
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['user']['nama_lengkap']) ?>" disabled>
                            <input type="hidden" name="id_penulis" value="<?= $_SESSION['user']['id'] ?>">
                        <?php else: ?>
                            <select class="form-select" id="id_penulis" name="id_penulis" required>
                                <option value="">Pilih Penulis</option>
                                <?php foreach ($members as $member): ?>
                                    <option value="<?= $member['id_anggota'] ?>" <?= (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $member['id_anggota']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($member['nama_lengkap']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending">Tertunda</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Focus Modal -->
<div class="modal fade" id="editFocusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Fokus Riset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFocusForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Bidang Riset</label>
                        <input type="text" name="bidang" id="edit_bidang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_penulis" class="form-label">Penulis</label>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'operator'): ?>
                            <input type="hidden" id="edit_id_penulis" name="id_penulis">
                            <input type="text" class="form-control"
                                value="<?= htmlspecialchars($_SESSION['user']['nama_lengkap']) ?>" disabled>
                        <?php else: ?>
                            <select class="form-select" id="edit_id_penulis" name="id_penulis" required>
                                <option value="">Pilih Penulis</option>
                                <?php foreach ($members as $member): ?>
                                    <option value="<?= $member['id_anggota'] ?>">
                                        <?= htmlspecialchars($member['nama_lengkap']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status">
                                <option value="pending">Tertunda</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3" id="rejection_note_container" style="display: none;">
                        <label class="form-label text-danger">Catatan Penolakan</label>
                        <div class="alert alert-danger bg-danger-subtle border-danger text-danger p-2 mb-0 text-sm"
                            id="rejection_note"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger">Konfirmasi Penghapusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Apakah Anda yakin ingin menghapus fokus riset ini? Tindakan ini tidak dapat
                dibatalkan.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let deleteId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        window.editFocus = function (id, bidang, penulis, status, catatan) {
            $('#editFocusForm').attr('action', '/admin/fokus/' + id + '/update');
            $('#edit_bidang').val(bidang);

            if ($('#edit_id_penulis').is('select')) {
                $('#edit_id_penulis').val(penulis);
            } else {
                $('#edit_id_penulis').val(penulis);
            }

            // Handle status
            if ($('#edit_status').length) {
                $('#edit_status').val(status);
            }

            // Handle rejection note
            if (status === 'rejected' && catatan) {
                $('#rejection_note').text(catatan);
                $('#rejection_note_container').show();
            } else {
                $('#rejection_note_container').hide();
            }
        };

        window.confirmDelete = function (id) {
            deleteId = id;
            deleteModal.show();
        };

        $('#confirmDeleteBtn').click(function () {
            if (deleteId) {
                $('#deleteForm-' + deleteId).submit();
            }
        });
    });
</script>