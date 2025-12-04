<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">

        <?php
        $articles = $news ?? [];
        $hero = $articles[0] ?? null;
        ?>

        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="position-relative overflow-hidden rounded-4">
                    <img src="/<?= $hero['gambar_utama'] ?? 'assets/images/frame.png' ?>" alt=""
                        class="w-100 img-fluid rounded-4">
                    <span class="position-absolute top-0 start-0 m-3 p-2 badge bg-white" style="color: #0F9ECC;">
                        Artikel Terbaru
                    </span>

                    <!-- Content -->
                    <?php if ($hero): ?>
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white text-wrap">
                            <h5 class="fw-semibold mb-1">
                                <?= htmlspecialchars($hero['judul']) ?>
                            </h5>
                            <p class="mb-0 small text-truncate">
                                <?= nl2br(htmlspecialchars(substr($hero['isi_berita'], 0, 220))) ?>
                            </p>
                            <a href="/news/<?= htmlspecialchars($hero['slug']) ?>" class="btn btn-outline-light mt-2">Baca Selengkapnya</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-xl-4 d-flex flex-column gap-3">
                <?php for ($i = 1; $i <= 3; $i++):
                    $side = $articles[$i] ?? null;
                    if (!$side) continue;
                ?>
                    <a href="/news/<?= htmlspecialchars($side['slug']) ?>" class="border rounded-3 p-3 d-flex align-items-center gap-2 text-decoration-none">
                        <img src="/<?= $side['gambar_utama'] ?? 'assets/images/frame.png' ?>" alt="News Image"
                            class="rounded-3" style="width: 148px; height: auto; object-fit: cover;">
                        <div class="d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 12px;">
                                <p class="m-0"><?= date('d M, Y', strtotime($side['tanggal_posting'] ?? 'now')) ?></p>
                                <p class="m-0">—</p>
                            </div>
                            <p class="m-0 fw-semibold" style="font-size: 14px; color: #0F9ECC;"><?= htmlspecialchars($side['judul']) ?></p>
                        </div>
                    </a>
                <?php endfor; ?>
            </div>
        </div>

        <h2 class="text-vision-gradient" style="font-size: 40px; font-weight: bold;">Berita & Artikel Laboratorium</h2>

        <div class="d-flex justify-content-between align-items-center my-4">
            <ul class="nav nav-tabs gallery-tabs justify-content-start">
                <li class="nav-item"><a class="nav-link active" href="#">Semua</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kegiatan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ruang Lab</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Acara</a></li>
            </ul>
            <div class="input-group w-25">
                <input type="text" class="form-control" style="background-color: #F0F0F0;" placeholder="Search articles"
                    aria-label="Search" aria-describedby="button-search">
                <button class="btn btn-secondary" type="submit" id="button-search"><i class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <?php if (empty($articles)): ?>
                <div class="col-12 text-center text-muted py-5">Belum ada berita tersedia.</div>
            <?php else: ?>
                <?php foreach ($articles as $a): ?>
                    <div class="col-lg-4">
                        <div class="card shadow rounded-3 p-3 card-news">
                            <div class="text-center">
                                <img src="/<?= htmlspecialchars($a['gambar_utama'] ?? 'assets/images/frame.png') ?>" alt="News Image" class="w-100 rounded-3" style="height: 189px; object-fit: cover;">
                            </div>
                            <div class="card-body text-start p-0">
                                <h5 class="card-title fw-semibold py-3 fs-6 m-0" style="color: #5F983C;"><?= htmlspecialchars($a['judul']) ?></h5>
                                <p class="card-text all-text-gradient"><?= nl2br(htmlspecialchars(substr($a['isi_berita'], 0, 160))) ?></p>
                                <p class="text-muted small mt-2"><?= date('d F Y', strtotime($a['tanggal_posting'] ?? 'now')) ?></p>
                                <a href="/news/<?= htmlspecialchars($a['slug']) ?>" class="btn btn-outline-dark mt-2 w-100">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($pagination)): ?>
            <?php include __DIR__ . '/partials/pagination.php'; ?>
        <?php endif; ?>
    </div>