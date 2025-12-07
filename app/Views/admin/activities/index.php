<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark"><?= $title ?></h5>
            <p class="text-muted small mb-0">Manajemen kegiatan dan proyek lab</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addActivityModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Kegiatan</span>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kegiatan
                        </th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Deskripsi</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Penulis</th>
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($activities)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-calendar-event display-4 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada kegiatan</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($activities as $activity): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php if (!empty($activity['gambar'])): ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-primary"
                                                style="width: 60px; height: 60px; font-size: 24px;">
                                                <i class="<?= htmlspecialchars($activity['gambar']) ?>"></i>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted"
                                                style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-bold text-dark"><?= htmlspecialchars($activity['judul_kegiatan']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-xs text-muted text-truncate d-block"
                                        style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars(strip_tags($activity['deskripsi'])) ?></span>
                                </td>
                                <td>
                                    <span
                                        class="text-sm text-dark fw-medium"><?= htmlspecialchars($activity['penulis'] ?? 'System') ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex align-items-center gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editActivity('<?= $activity['id_kegiatan'] ?>', '<?= htmlspecialchars($activity['judul_kegiatan']) ?>', '<?= htmlspecialchars($activity['deskripsi']) ?>', '<?= htmlspecialchars($activity['gambar'] ?? '') ?>', '<?= $activity['id_penulis'] ?? '' ?>')"
                                            data-bs-toggle="modal" data-bs-target="#editActivityModal" title="Edit Kegiatan">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete('<?= $activity['id_kegiatan'] ?>')" title="Hapus Kegiatan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="deleteForm-<?= $activity['id_kegiatan'] ?>"
                                        action="/admin/activities/<?= $activity['id_kegiatan'] ?>/delete" method="POST"
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

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Kegiatan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/activities" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="judul_kegiatan" name="judul_kegiatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Icon Class (Bootstrap Icons)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="gambar" name="gambar"
                                placeholder="e.g. bi bi-laptop">
                            <button class="btn btn-outline-secondary" type="button" id="btnPickIcon">
                                <i class="bi bi-search"></i> Pilih
                            </button>
                        </div>
                        <div class="form-text text-muted">Lihat daftar icon di <a href="https://icons.getbootstrap.com/"
                                target="_blank">Bootstrap Icons</a></div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editActivityForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_judul_kegiatan" class="form-label">Judul Kegiatan</label>
                        <input type="text" class="form-control" id="edit_judul_kegiatan" name="judul_kegiatan" required>
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
                                placeholder="e.g. bi bi-laptop">
                            <button class="btn btn-outline-secondary" type="button" id="btnPickEditIcon">
                                <i class="bi bi-search"></i> Pilih
                            </button>
                        </div>
                        <div class="form-text text-muted">Lihat daftar icon di <a href="https://icons.getbootstrap.com/"
                                target="_blank">Bootstrap Icons</a></div>
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
<div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus kegiatan ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteActivityId = null;

    function editActivity(id, judul, deskripsi, gambar, penulis) {
        $('#editActivityForm').attr('action', '/admin/activities/' + id + '/update');
        $('#edit_judul_kegiatan').val(judul);
        $('#edit_deskripsi').val(deskripsi);

        $('#edit_gambar').val(gambar);

        // Handle penulis
        if ($('#edit_id_penulis').is('select')) {
            $('#edit_id_penulis').val(penulis);
        } else {
            // For operator, we keep it as is, or if logic dictates we overwrite with current user?
            // Based on News implementation, we set the hidden input.
            $('#edit_id_penulis').val(penulis);
        }
    }

    function confirmDelete(id) {
        deleteActivityId = id;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteActivityModal'));
        deleteModal.show();
    }

    $(document).ready(function () {
        // Initialize Icon Pickers
        initIconPicker('#btnPickIcon', '#gambar');
        initIconPicker('#btnPickEditIcon', '#edit_gambar');

        $('#confirmDeleteBtn').on('click', function () {
            if (deleteActivityId) {
                $('#deleteForm-' + deleteActivityId).submit();
            }
        });
    });
</script>