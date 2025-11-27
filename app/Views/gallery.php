<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient" style="font-size: 40px; font-weight: bold;">Galeri Foto Laboratorium
        </h2>

        <ul class="nav nav-tabs mt-5 gallery-tabs justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" href="#">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Kegiatan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Ruang Lab</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Acara</a>
            </li>
        </ul>

        <div class="row justify-content-center align-items-center g-4 mt-2">
            <?php if (empty($photos)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada foto di galeri.</p>
                </div>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="col-6 col-lg-4 d-flex flex-column align-items-center">
                        <img src="/<?= htmlspecialchars($photo['file_path']) ?>"
                            alt="<?= htmlspecialchars($photo['judul_foto']) ?>" class="img-fluid rounded-3 border gallery-img"
                            style="width: 344px; height: 250px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal"
                            data-bs-target="#imageModal" data-image="/<?= htmlspecialchars($photo['file_path']) ?>">
                        <p class="text-center mt-2 fw-semibold"><?= htmlspecialchars($photo['judul_foto']) ?></p>
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

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 bg-transparent">
            <img id="modalImage" src="" class="img-fluid rounded-3">
        </div>
    </div>
</div>