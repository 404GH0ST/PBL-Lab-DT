<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient" style="font-size: 40px; font-weight: bold;">Fasilitas Laboratorium
        </h2>

        <div class="row g-4 mt-2 mb-5">
            <?php if (empty($facilities)): ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-building display-4 mb-3"></i>
                    <p>No facilities available.</p>
                </div>
            <?php else: ?>
                <?php foreach ($facilities as $f): ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card-modern h-100 overflow-hidden p-0">
                            <div class="position-relative" style="height: 200px;">
                                <?php if (!empty($f['foto_fasilitas'])): ?>
                                    <img src="/<?= htmlspecialchars($f['foto_fasilitas']) ?>"
                                        alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>" class="w-100 h-100 object-fit-cover">
                                <?php else: ?>
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <i class="bi bi-building display-4 text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h5 class="fw-bold mb-2"><?= htmlspecialchars($f['nama_fasilitas']) ?></h5>
                                <p class="text-muted small mb-3">
                                    <?= htmlspecialchars($f['deskripsi'] ?? '') ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center text-secondary small">
                                    <span><i class="bi bi-pc-display me-1"></i> <?= (int) $f['jumlah_unit'] ?> Units</span>
                                    <span><i class="bi bi-check-circle me-1"></i> <?= htmlspecialchars($f['kondisi']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?= $pagination->renderPublic($baseUrl) ?>
        </div>

    </div>
</section>