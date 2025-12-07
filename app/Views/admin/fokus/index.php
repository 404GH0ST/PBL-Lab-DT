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
    <div class="card-body">
        <?php if (empty($focus)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-lightbulb display-4 mb-3 opacity-50"></i>
                <p class="mb-0">Belum ada fokus riset.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($focus as $f): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="text-center pt-3">
                                <?php if (!empty($f['ikon'])): ?>
                                    <img src="/<?= htmlspecialchars($f['ikon']) ?>" class="rounded mb-3" alt="Icon" style="width:96px; height:96px; object-fit:cover;">
                                <?php else: ?>
                                    <div class="rounded-circle mb-3 bg-light d-flex align-items-center justify-content-center" style="width:96px; height:96px;">
                                        <i class="bi bi-lightbulb fs-2 text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-start">
                                <h6 class="card-title fw-bold text-truncate"><?= htmlspecialchars($f['judul']) ?></h6>
                                <p class="text-muted small mb-0"><?= nl2br(htmlspecialchars(substr($f['deskripsi'] ?? '', 0, 200))) ?></p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-light text-primary" onclick="editFocus(<?= $f['id_fokus'] ?>, '<?= htmlspecialchars(addslashes($f['judul'])) ?>', '<?= htmlspecialchars(addslashes($f['deskripsi'] ?? '')) ?>', '<?= htmlspecialchars($f['ikon'] ?? '') ?>')" data-bs-toggle="modal" data-bs-target="#editFocusModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-light text-danger" onclick="confirmDelete(<?= $f['id_fokus'] ?>)">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                <form id="deleteForm-<?= $f['id_fokus'] ?>" action="/admin/fokus/<?= $f['id_fokus'] ?>/delete" method="POST" class="d-none"></form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
            <form action="/admin/fokus" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ikon (opsional)</label>
                        <input type="file" name="ikon" accept="image/*" class="form-control">
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
            <form id="editFocusForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" id="edit_judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Ikon (opsional)</label>
                        <input type="file" name="ikon" accept="image/*" class="form-control">
                        <div class="mt-2" id="current_icon_container" style="display:none;">
                            <small class="text-muted d-block mb-1">Ikon Saat Ini:</small>
                            <img src="" id="current_icon" class="img-fluid rounded border" style="max-height:80px;">
                        </div>
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
            <div class="modal-body">Apakah Anda yakin ingin menghapus fokus riset ini? Tindakan ini tidak dapat dibatalkan.</div>
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

        window.editFocus = function (id, judul, deskripsi, ikon) {
            $('#editFocusForm').attr('action', '/admin/fokus/' + id + '/update');
            $('#edit_judul').val(judul);
            $('#edit_deskripsi').val(deskripsi);

            if (ikon) {
                $('#current_icon').attr('src', '/' + ikon);
                $('#current_icon_container').show();
            } else {
                $('#current_icon_container').hide();
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
