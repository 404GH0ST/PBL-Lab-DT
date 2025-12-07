<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient" style="font-size: 40px; font-weight: bold;">Galeri Foto Laboratorium</h2>

        <style>
            .nav-pills .nav-link {
                color: #575757;
                font-weight: 600;
                background-color: #fff;
                border: 1px solid #e0e0e0;
                margin-right: 10px;
                border-radius: 8px;
                padding: 8px 20px;
                transition: all 0.3s ease;
            }

            .nav-pills .nav-link:hover {
                background-color: #f8f9fa;
                border-color: #d0d0d0;
            }

            .nav-pills .nav-link.active {
                background-color: #7ABA54;
                color: #fff;
                border-color: #7ABA54;
            }
        </style>

        <!-- Filter Tabs -->
        <ul class="nav nav-pills gallery-tabs justify-content-start mt-5 mb-4" id="gallery-tabs">
            <li class="nav-item">
                <a class="nav-link <?= $currentCategory === 'Semua' ? 'active' : '' ?>" href="/gallery">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentCategory === 'Kegiatan' ? 'active' : '' ?>"
                    href="/gallery?category=Kegiatan">Kegiatan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentCategory === 'Ruang Lab' ? 'active' : '' ?>"
                    href="/gallery?category=Ruang Lab">Ruang Lab</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentCategory === 'Acara' ? 'active' : '' ?>"
                    href="/gallery?category=Acara">Acara</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $currentCategory === 'Lainnya' ? 'active' : '' ?>"
                    href="/gallery?category=Lainnya">Lainnya</a>
            </li>
        </ul>

        <div class="row justify-content-center align-items-center g-4 mt-2">
            <?php if (empty($photos)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada foto di galeri.</p>
                </div>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="col-6 col-lg-4">
                        <div class="card-modern overflow-hidden p-0 gallery-item" style="height: 250px; cursor: pointer;"
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-image="/<?= htmlspecialchars($photo['file_path']) ?>">
                            <img src="/<?= htmlspecialchars($photo['file_path']) ?>"
                                alt="<?= htmlspecialchars($photo['deskripsi']) ?>" class="img-fluid w-100 h-100"
                                style="object-fit: cover; transition: transform 0.5s ease;">
                            <div class="gallery-overlay">
                                <p class="mb-0 fw-semibold"><?= htmlspecialchars($photo['deskripsi'] ?? '') ?></p>
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

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 bg-transparent">
            <img id="modalImage" src="" class="img-fluid rounded-3">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var imageUrl = button.getAttribute('data-image');
            var modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageUrl;
        });
    });
</script>