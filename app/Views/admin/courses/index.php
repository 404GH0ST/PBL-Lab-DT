<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark"><?= $title ?></h5>
            <p class="text-muted small mb-0">Manajemen mata kuliah terkait lab</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addCourseModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Perkuliahan</span>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Perkuliahan
                        </th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deskripsi</th>
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-book display-4 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada perkuliahan</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if (!empty($course['gambar'])): ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-primary"
                                                style="width: 60px; height: 60px; font-size: 24px;">
                                                <i class="<?= htmlspecialchars($course['gambar']) ?>"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted"
                                                style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold text-dark"><?= htmlspecialchars($course['judul_perkuliahan']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-xs text-muted text-truncate d-block"
                                        style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars(strip_tags($course['deskripsi'])) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editCourse('<?= $course['id_perkuliahan'] ?>', '<?= htmlspecialchars($course['judul_perkuliahan']) ?>', '<?= htmlspecialchars($course['deskripsi']) ?>', '<?= htmlspecialchars($course['gambar'] ?? '') ?>')"
                                            data-bs-toggle="modal" data-bs-target="#editCourseModal" title="Edit Perkuliahan">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete('<?= $course['id_perkuliahan'] ?>')"
                                            title="Hapus Perkuliahan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="deleteForm-<?= $course['id_perkuliahan'] ?>"
                                        action="/admin/courses/<?= $course['id_perkuliahan'] ?>/delete" method="POST"
                                        class="d-none">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Perkuliahan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/courses" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul_perkuliahan" class="form-label">Judul Perkuliahan</label>
                        <input type="text" class="form-control" id="judul_perkuliahan" name="judul_perkuliahan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="gambar" name="gambar"
                                placeholder="e.g. bi bi-book">
                            <button class="btn btn-outline-secondary" type="button" id="btnPickIcon">
                                <i class="bi bi-search"></i> Pilih
                            </button>
                        </div>
                        <div class="form-text text-muted">Lihat daftar icon di <a href="https://icons.getbootstrap.com/"
                                target="_blank">Bootstrap Icons</a></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Perkuliahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCourseForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul_perkuliahan" class="form-label">Judul Perkuliahan</label>
                        <input type="text" class="form-control" id="edit_judul_perkuliahan" name="judul_perkuliahan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="5"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Icon Class</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit_gambar" name="gambar"
                                placeholder="e.g. bi bi-book">
                            <button class="btn btn-outline-secondary" type="button" id="btnPickEditIcon">
                                <i class="bi bi-search"></i> Pilih
                            </button>
                        </div>
                        <div class="form-text text-muted">Lihat daftar icon di <a href="https://icons.getbootstrap.com/"
                                target="_blank">Bootstrap Icons</a></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus perkuliahan ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteCourseId = null;

    function editCourse(id, judul, deskripsi, gambar) {
        $('#editCourseForm').attr('action', '/admin/courses/' + id + '/update');
        $('#edit_judul_perkuliahan').val(judul);
        $('#edit_deskripsi').val(deskripsi);

        $('#edit_gambar').val(gambar);
    }

    function confirmDelete(id) {
        deleteCourseId = id;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCourseModal'));
        deleteModal.show();
    }

    $(document).ready(function () {
        // Initialize Icon Pickers
        initIconPicker('#btnPickIcon', '#gambar');
        initIconPicker('#btnPickEditIcon', '#edit_gambar');

        $('#confirmDeleteBtn').on('click', function () {
            if (deleteCourseId) {
                $('#deleteForm-' + deleteCourseId).submit();
            }
        });
    });
</script>