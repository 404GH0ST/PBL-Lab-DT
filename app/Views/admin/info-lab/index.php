<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0 fw-bold text-dark">Struktur Organisasi</h5>
                <p class="text-muted small mb-0">Upload gambar struktur organisasi lab</p>
            </div>
            <div class="card-body">
                <?php if (($contact['status'] ?? '') === 'rejected' && !empty($contact['catatan_admin'])): ?>
                    <div class="alert alert-danger bg-danger-subtle border-danger text-danger mb-4">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                            <h6 class="mb-0 fw-bold">Perubahan Ditolak</h6>
                        </div>
                        <p class="mb-0 small"><?= htmlspecialchars($contact['catatan_admin']) ?></p>
                    </div>
                <?php endif; ?>

                <form action="/admin/info-lab/update" method="POST" enctype="multipart/form-data">
                    <!-- Structure Image Section -->
                    <div class="mb-4 text-center">
                        <div class="mb-3">
                            <?php if (!empty($struktur['isi_konten'])): ?>
                                <img src="/uploads/struktur/<?= htmlspecialchars($struktur['isi_konten']) ?>"
                                    alt="Struktur Organisasi" class="img-fluid rounded border shadow-sm"
                                    style="max-height: 400px;">
                            <?php else: ?>
                                <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <span class="text-muted">Belum ada gambar struktur organisasi</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="input-group w-50 mx-auto">
                            <input type="file" class="form-control" name="struktur_image" accept="image/*">
                        </div>
                        <div class="form-text">Format: JPG, PNG. Maks: 2MB.</div>
                    </div>

                    <hr>
                    <h5 class="fw-bold mb-3">Informasi Kontak & Sosial Media</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_lab" class="form-label fw-bold">Nama Lab</label>
                            <input type="text" class="form-control" id="nama_lab" name="nama_lab"
                                value="<?= htmlspecialchars($contact['nama_lab'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon"
                                value="<?= htmlspecialchars($contact['telepon'] ?? '') ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="alamat" class="form-label fw-bold">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat"
                                rows="3"><?= htmlspecialchars($contact['alamat'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi (Footer)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"
                                rows="3"><?= htmlspecialchars($contact['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12 mt-3 mb-3">
                            <h6 class="fw-bold text-secondary text-uppercase small">Media Sosial & Tautan</h6>
                            <hr class="mt-1">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="link_maps" class="form-label fw-bold">Tautan Google Maps</label>
                            <input type="url" class="form-control" id="link_maps" name="link_maps"
                                value="<?= htmlspecialchars($contact['link_maps'] ?? '') ?>"
                                placeholder="https://maps.google.com/...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_instagram" class="form-label fw-bold">URL Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-instagram"></i></span>
                                <input type="url" class="form-control" id="link_instagram" name="link_instagram"
                                    value="<?= htmlspecialchars($contact['link_instagram'] ?? '') ?>"
                                    placeholder="https://instagram.com/...">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_linkedin" class="form-label fw-bold">URL LinkedIn</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-linkedin"></i></span>
                                <input type="url" class="form-control" id="link_linkedin" name="link_linkedin"
                                    value="<?= htmlspecialchars($contact['link_linkedin'] ?? '') ?>"
                                    placeholder="https://linkedin.com/...">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_facebook" class="form-label fw-bold">URL Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-facebook"></i></span>
                                <input type="url" class="form-control" id="link_facebook" name="link_facebook"
                                    value="<?= htmlspecialchars($contact['link_facebook'] ?? '') ?>"
                                    placeholder="https://facebook.com/...">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_twitter" class="form-label fw-bold">URL Twitter/X</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-twitter-x"></i></span>
                                <input type="url" class="form-control" id="link_twitter" name="link_twitter"
                                    value="<?= htmlspecialchars($contact['link_twitter'] ?? '') ?>"
                                    placeholder="https://twitter.com/...">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="link_youtube" class="form-label fw-bold">URL YouTube</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-youtube"></i></span>
                                <input type="url" class="form-control" id="link_youtube" name="link_youtube"
                                    value="<?= htmlspecialchars($contact['link_youtube'] ?? '') ?>"
                                    placeholder="https://youtube.com/...">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>