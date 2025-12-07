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
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7"
                            style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($focus)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
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
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editFocus(<?= $f['id_fokus'] ?>, '<?= htmlspecialchars(addslashes($f['bidang'])) ?>')"
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

        window.editFocus = function (id, bidang) {
            $('#editFocusForm').attr('action', '/admin/fokus/' + id + '/update');
            $('#edit_bidang').val(bidang);
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