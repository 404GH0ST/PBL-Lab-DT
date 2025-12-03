<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark">Facility Management</h5>
            <p class="text-muted small mb-0">Manage laboratory facilities</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addFacilityModal">
            <i class="bi bi-plus-circle"></i>
            <span>Add Facility</span>
        </button>
    </div>
    <div class="card-body">
        <?php if (empty($facilities)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-building display-4 mb-3 opacity-50"></i>
                <p class="mb-0">No facilities found</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($facilities as $f): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="position-relative">
                                <?php if (!empty($f['foto_fasilitas'])): ?>
                                    <img src="/<?= htmlspecialchars($f['foto_fasilitas']) ?>" class="card-img-top" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>" style="height: 180px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="/assets/images/frame.png" class="card-img-top" alt="no image" style="height: 180px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-truncate"><?= htmlspecialchars($f['nama_fasilitas']) ?></h6>
                                <p class="card-text small text-muted mb-2">Units: <?= (int)$f['jumlah_unit'] ?> &middot; Kondisi: <?= htmlspecialchars($f['kondisi']) ?></p>
                                <p class="card-text small text-muted"><?= htmlspecialchars(substr($f['deskripsi'] ?? '', 0, 120)) ?><?= strlen($f['deskripsi'] ?? '') > 120 ? '...' : '' ?></p>
                            </div>
                            <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-light text-primary" onclick="editFacility(<?= $f['id_fasilitas'] ?>, '<?= htmlspecialchars(addslashes($f['nama_fasilitas'])) ?>', '<?= htmlspecialchars(addslashes($f['deskripsi'] ?? '')) ?>', <?= (int)$f['jumlah_unit'] ?>, '<?= $f['kondisi'] ?>', '<?= htmlspecialchars($f['foto_fasilitas'] ?? '') ?>')" data-bs-toggle="modal" data-bs-target="#editFacilityModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-light text-danger" onclick="confirmDelete(<?= $f['id_fasilitas'] ?>)">
                                    <i class="bi bi-trash"></i> Delete
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
                <h5 class="modal-title fw-bold">Add New Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/fasilitas" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_fasilitas" class="form-label">Facility Name</label>
                        <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_unit" class="form-label">Units</label>
                        <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="kondisi" class="form-label">Condition</label>
                        <select class="form-select" id="kondisi" name="kondisi">
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="foto_fasilitas" class="form-label">Photo (optional)</label>
                        <input type="file" class="form-control" id="foto_fasilitas" name="foto_fasilitas" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Add Facility</button>
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
                <h5 class="modal-title fw-bold">Edit Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFacilityForm" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_fasilitas" class="form-label">Facility Name</label>
                        <input type="text" class="form-control" id="edit_nama_fasilitas" name="nama_fasilitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_unit" class="form-label">Units</label>
                        <input type="number" class="form-control" id="edit_jumlah_unit" name="jumlah_unit" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="edit_kondisi" class="form-label">Condition</label>
                        <select class="form-select" id="edit_kondisi" name="kondisi">
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto_fasilitas" class="form-label">Replace Photo (optional)</label>
                        <input type="file" class="form-control" id="edit_foto_fasilitas" name="foto_fasilitas" accept="image/*">
                        <div class="mt-2" id="current_photo_container">
                            <small class="text-muted d-block mb-1">Current Photo:</small>
                            <img src="" id="current_photo" class="img-fluid rounded border" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Update Facility</button>
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
                <h5 class="modal-title fw-bold text-danger">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this facility? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let deleteId = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        window.editFacility = function (id, name, desc, units, kondisi, foto) {
            $('#editFacilityForm').attr('action', '/admin/fasilitas/' + id + '/update');
            $('#edit_nama_fasilitas').val(name);
            $('#edit_deskripsi').val(desc);
            $('#edit_jumlah_unit').val(units);
            $('#edit_kondisi').val(kondisi);

            if (foto) {
                $('#current_photo').attr('src', '/' + foto);
                $('#current_photo_container').show();
            } else {
                $('#current_photo_container').hide();
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

        // Basic form validation
        $('form').on('submit', function (e) {
            const requiredInputs = $(this).find('input[required], select[required], textarea[required]');
            let isValid = true;

            requiredInputs.each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });

        $('input, select, textarea').on('input change', function () {
            $(this).removeClass('is-invalid');
        });
    });
</script>
