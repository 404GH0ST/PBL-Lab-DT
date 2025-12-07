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
                        <div class="card shadow rounded-3 p-3 card-facility">
                            <div class="text-center">
                                <?php if (!empty($f['foto_fasilitas'])): ?>
                                    <img src="/<?= htmlspecialchars($f['foto_fasilitas']) ?>" alt="<?= htmlspecialchars($f['nama_fasilitas']) ?>" class="mx-auto d-block" style="width: 296px; height: 189px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="/assets/images/frame.png" alt="Facility Image" class="mx-auto d-block" style="width: 296px; height: 189px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body text-start">
                                <h5 class="card-title all-text-gradient fw-semibold py-3"><?= htmlspecialchars($f['nama_fasilitas']) ?></h5>
                                <p class="card-text all-text-gradient">
                                    <?= nl2br(htmlspecialchars($f['deskripsi'] ?? '')) ?>
                                </p>
                                <p class="text-muted small mt-2">Units: <?= (int)$f['jumlah_unit'] ?> &middot; Kondisi: <?= htmlspecialchars($f['kondisi']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center align-items-center mx-auto mt-4 p-2 rounded-3 custom-pagination"
                style="width: fit-content; background-color: #F0F0F0;">
                <li class="page-item">
                    <a class="page-link arrow" href="#"><i class="bi bi-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">....</a></li>
                <li class="page-item"><a class="page-link" href="#">10</a></li>
                <li class="page-item">
                    <a class="page-link arrow" href="#"><i class="bi bi-chevron-right"></i></a>
                </li>
            </ul>
        </nav>

    </div>
</section>