<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0 fw-bold text-dark">Persetujuan Tertunda</h5>
        <p class="text-muted small mb-0">Tinjau dan setujui kiriman yang tertunda</p>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs mb-4" id="approvalTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news" type="button"
                    role="tab" aria-controls="news" aria-selected="true">
                    Berita <span class="badge bg-danger rounded-pill ms-2"><?= count($pendingNews) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button"
                    role="tab" aria-controls="gallery" aria-selected="false">
                    Galeri <span class="badge bg-danger rounded-pill ms-2"><?= count($pendingGallery) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="publications-tab" data-bs-toggle="tab" data-bs-target="#publications"
                    type="button" role="tab" aria-controls="publications" aria-selected="false">
                    Publikasi <span class="badge bg-danger rounded-pill ms-2"><?= count($pendingPublications) ?></span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="approvalTabsContent">
            <!-- News Tab -->
            <div class="tab-pane fade show active" id="news" role="tabpanel" aria-labelledby="news-tab">
                <?php if (empty($pendingNews)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle display-4 mb-3 opacity-50"></i>
                        <p class="mb-0">Tidak ada berita tertunda</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Artikel</th>
                                    <th>Penulis</th>
                                    <th>Tanggal</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingNews as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['gambar_utama'])): ?>
                                                    <img src="/<?= htmlspecialchars($item['gambar_utama']) ?>" class="rounded me-3"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-bold text-dark"><?= htmlspecialchars($item['judul']) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($item['penulis']) ?></td>
                                        <td><?= date('M d, Y', strtotime($item['tanggal_posting'])) ?></td>
                                        <td class="text-end pe-4">
                                            <form action="/admin/approvals/news/<?= $item['id_berita'] ?>/approve" method="POST"
                                                class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger text-white ms-1"
                                                onclick="openRejectModal('news', <?= $item['id_berita'] ?>)" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Gallery Tab -->
            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                <?php if (empty($pendingGallery)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle display-4 mb-3 opacity-50"></i>
                        <p class="mb-0">Tidak ada foto tertunda</p>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($pendingGallery as $item): ?>
                            <div class="col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="/<?= htmlspecialchars($item['file_path']) ?>" class="card-img-top"
                                        style="height: 200px; object-fit: cover;" alt="Gallery Image">
                                    <div class="card-body">
                                        <p class="card-text small text-muted mb-2">Oleh
                                            <?= htmlspecialchars($item['uploader']) ?>
                                        </p>
                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <form action="/admin/approvals/gallery/<?= $item['id_galeri'] ?>/approve"
                                                method="POST">
                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger text-white"
                                                onclick="openRejectModal('gallery', <?= $item['id_galeri'] ?>)" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Publications Tab -->
            <div class="tab-pane fade" id="publications" role="tabpanel" aria-labelledby="publications-tab">
                <?php if (empty($pendingPublications)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check-circle display-4 mb-3 opacity-50"></i>
                        <p class="mb-0">Tidak ada publikasi tertunda</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Judul</th>

                                    <th>Tahun</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingPublications as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <span
                                                    class="fw-bold text-dark"><?= htmlspecialchars($item['judul_publikasi']) ?></span>
                                                <?php if (!empty($item['link_publikasi'])): ?>
                                                    <a href="<?= htmlspecialchars($item['link_publikasi']) ?>" target="_blank"
                                                        class="text-xs text-primary">Lihat Tautan</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td><?= htmlspecialchars($item['tahun_terbit']) ?></td>
                                        <td class="text-end pe-4">
                                            <form action="/admin/approvals/publication/<?= $item['id_publikasi'] ?>/approve"
                                                method="POST" class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-success text-white" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger text-white ms-1"
                                                onclick="openRejectModal('publication', <?= $item['id_publikasi'] ?>)"
                                                title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tolak Kiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="catatan_admin" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3" required
                            placeholder="Silakan berikan alasan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRejectModal(type, id) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/approvals/${type}/${id}/reject`;
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        modal.show();
    }
</script>