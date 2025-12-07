<?php
// Admin - Facility Management View
?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark">Manajemen Fasilitas</h5>
            <p class="text-muted small mb-0">Kelola daftar fasilitas laboratorium</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addFacilityModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Fasilitas</span>
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($facilities)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-building display-4 mb-3 opacity-50"></i>
                <p class="mb-0">Tidak ada fasilitas ditemukan</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($facilities as $f): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="text-center pt-3">
                                <?php if (!empty($f['foto_fasilitas'])): ?>
                                    <img src="/<?= htmlspecialchars($f['foto_fasilitas']) ?>" class="card-img-top"
                                        alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>" style="height:180px; width:100%; object-fit:cover;">
                                <?php else: ?>
                                    <img src="/assets/images/frame.png" class="card-img-top" alt="No Image"
                                        style="height:180px; width:100%; object-fit:cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-truncate"><?= htmlspecialchars($f['nama_fasilitas']) ?></h6>
                                <p class="text-muted small mb-2">Jumlah Unit: <?= (int)$f['jumlah_unit'] ?> &middot; Kondisi: <?= htmlspecialchars($f['kondisi']) ?></p>
                                <p class="mb-0"><?= nl2br(htmlspecialchars($f['deskripsi'] ?? '')) ?></p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-light text-primary" onclick="editFacility(<?= $f['id_fasilitas'] ?>, '<?= htmlspecialchars(addslashes($f['nama_fasilitas'])) ?>', '<?= htmlspecialchars(addslashes($f['deskripsi'] ?? '')) ?>', <?= (int)$f['jumlah_unit'] ?>, '<?= htmlspecialchars($f['kondisi']) ?>', '<?= htmlspecialchars($f['foto_fasilitas'] ?? '') ?>')" data-bs-toggle="modal" data-bs-target="#editFacilityModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-light text-danger" onclick="confirmDelete(<?= $f['id_fasilitas'] ?>)">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                <form id="deleteForm-<?= $f['id_fasilitas'] ?>" action="/admin/fasilitas/<?= $f['id_fasilitas'] ?>/delete" method="POST" class="d-none"></form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add Facility Modal -->
<div class="modal fade" id="addFacilityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Fasilitas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/fasilitas" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Fasilitas</label>
                        <input type="text" name="nama_fasilitas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Unit</label>
                        <input type="number" name="jumlah_unit" class="form-control" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select">
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" name="foto_fasilitas" accept="image/*" class="form-control">
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

<!-- Edit Facility Modal -->
<div class="modal fade" id="editFacilityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFacilityForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Fasilitas</label>
                        <input type="text" name="nama_fasilitas" id="edit_nama_fasilitas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Unit</label>
                        <input type="number" name="jumlah_unit" id="edit_jumlah_unit" class="form-control" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" id="edit_kondisi" class="form-select">
                            <option value="baik">Baik</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Foto (opsional)</label>
                        <input type="file" name="foto_fasilitas" accept="image/*" class="form-control">
                        <div class="mt-2" id="current_facility_photo_container" style="display:none;">
                            <small class="text-muted d-block mb-1">Foto Saat Ini:</small>
                            <img src="" id="current_facility_photo" class="img-fluid rounded border" style="max-height:120px;">
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
            <div class="modal-body">Apakah Anda yakin ingin menghapus fasilitas ini? Tindakan ini tidak dapat dibatalkan.</div>
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

        window.editFacility = function (id, nama, deskripsi, jumlah, kondisi, foto) {
            $('#editFacilityForm').attr('action', '/admin/fasilitas/' + id + '/update');
            $('#edit_nama_fasilitas').val(nama);
            $('#edit_deskripsi').val(deskripsi);
            $('#edit_jumlah_unit').val(jumlah);
            $('#edit_kondisi').val(kondisi);

            if (foto) {
                $('#current_facility_photo').attr('src', '/' + foto);
                $('#current_facility_photo_container').show();
            } else {
                $('#current_facility_photo_container').hide();
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
