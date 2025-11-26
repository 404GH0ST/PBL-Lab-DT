<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title mb-1 fw-bold text-dark">Visi & Misi</h5>
            <p class="text-muted small mb-0">Kelola konten visi dan misi laboratorium</p>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#addVisiMisiModal">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Konten</span>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jenis</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Preview Konten</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Terakhir Diperbarui</th>
                        <th class="text-end pe-4 text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($visiMisi)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-lightbulb display-4 mb-3 opacity-50"></i>
                                    <p class="mb-0">Visi/Misi belum ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($visiMisi as $item): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark border">
                                        <?= ucfirst($item['jenis_konten']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary text-sm">
                                        <?= htmlspecialchars(substr($item['isi_konten'], 0, 60)) ?>...
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary text-sm">
                                        <?= date('d M Y H:i', strtotime($item['updated_at'])) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-light text-primary"
                                            onclick="editVisiMisi(<?= $item['id'] ?>, '<?= htmlspecialchars($item['jenis_konten']) ?>', `<?= htmlspecialchars($item['isi_konten']) ?>`)"
                                            data-bs-toggle="modal" data-bs-target="#editVisiMisiModal" title="Ubah Konten">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-danger ms-1"
                                            onclick="confirmDelete(<?= $item['id'] ?>)" title="Hapus Konten">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="deleteForm-<?= $item['id'] ?>"
                                        action="/admin/visimisi/<?= $item['id'] ?>/delete" method="POST"
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

<!-- Add Vision/Mission Modal -->
<div class="modal fade" id="addVisiMisiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Visi/Misi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/visimisi" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis_konten" class="form-label">Jenis Konten</label>
                        <select class="form-select" id="jenis_konten" name="jenis_konten" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="visi">Visi</option>
                            <option value="misi">Misi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="isi_konten" class="form-label">Isi Konten</label>
                        <textarea class="form-control" id="isi_konten" name="isi_konten" rows="6" required></textarea>
                        <small class="text-muted">Masukkan pernyataan visi atau misi laboratorium</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Vision/Mission Modal -->
<div class="modal fade" id="editVisiMisiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Ubah Visi/Misi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editVisiMisiForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_jenis_konten" class="form-label">Jenis Konten</label>
                        <input type="text" class="form-control" id="edit_jenis_konten" disabled>
                        <small class="text-muted">Jenis konten tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_isi_konten" class="form-label">Isi Konten</label>
                        <textarea class="form-control" id="edit_isi_konten" name="isi_konten" rows="6" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Perbarui Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editVisiMisi(id, type, content) {
        document.getElementById('editVisiMisiForm').action = '/admin/visimisi/' + id + '/update';
        document.getElementById('edit_jenis_konten').value = type.charAt(0).toUpperCase() + type.slice(1);
        document.getElementById('edit_isi_konten').value = content;
    }

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus Visi/Misi ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById('deleteForm-' + id).submit();
        }
    }
</script>

