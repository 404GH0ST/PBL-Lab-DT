<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Profil Anggota' ?></title>
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .nav-pills .nav-link {
            color: #575757;
            font-weight: 600;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            margin-right: 10px;
            border-radius: 8px;
        }

        .nav-pills .nav-link.active {
            background-color: #7ABA54;
            color: #fff;
            border-color: #7ABA54;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 8px;
        }

        .content-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            height: 100%;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .content-img {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
            width: 100%;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-text {
            color: #7ABA54;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .card-custom-btn {
            border: 1px solid #d0d0d0;
            background: transparent;
            color: #333;
            width: 100%;
            border-radius: 8px;
            font-weight: 600;
        }

        .card-custom-btn:hover {
            background: #f8f9fa;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <?php include __DIR__ . '/components/navbar.php'; ?>

    <div class="container py-5 mt-5">
        <h2 class="text-vision-gradient fw-bold mb-4" style="font-size: 32px;">Profile Anggota</h2>

        <!-- Profile Header Card -->
        <div class="card shadow-sm border-0 rounded-4 p-4 mb-5 bg-white">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <div class="rounded-circle overflow-hidden d-inline-block" style="width: 200px; height: 200px;">
                        <?php if (!empty($member['foto_profil'])): ?>
                            <img src="/uploads/foto_profil/<?= htmlspecialchars($member['foto_profil']) ?>"
                                alt="<?= htmlspecialchars($member['nama_lengkap']) ?>" class="w-100 h-100 object-fit-cover">
                        <?php else: ?>
                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-person display-1 text-secondary"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 border-end-md">
                            <h3 class="text-vision-gradient fw-bold mb-3">
                                <?= htmlspecialchars($member['nama_lengkap']) ?>
                            </h3>

                            <div class="mb-3">
                                <p class="text-secondary fw-bold mb-1" style="font-size: 14px;">Jabatan :</p>
                                <p class="mb-0 fw-medium">
                                    <?= $member['role'] === 'admin' ? 'Kepala Lab / Admin' : 'Anggota Laboratorium' ?>
                                </p>
                            </div>



                            <div class="mb-3">
                                <p class="text-secondary fw-bold mb-1" style="font-size: 14px;">NIP/NIM :</p>
                                <p class="mb-0 fw-medium"><?= htmlspecialchars($member['nip_nim'] ?? '-') ?></p>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <div class="mb-4">
                                <p class="text-secondary fw-bold mb-1" style="font-size: 14px;">Biografi :</p>
                                <p class="mb-0 text-muted">
                                    <?= !empty($member['bio']) ? nl2br(htmlspecialchars($member['bio'])) : 'Belum memiliki bio.' ?>
                                </p>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <p class="text-secondary fw-bold mb-1" style="font-size: 14px;">Email :</p>
                                    <p class="mb-0 fw-medium text-primary text-break">
                                        <?= htmlspecialchars($member['email']) ?>
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p class="text-secondary fw-bold mb-1" style="font-size: 14px;">Status :</p>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-3">
                                        <?= $member['status_aktif'] ? 'Aktif' : 'Tidak Aktif' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all"
                        type="button" role="tab">Semua</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-pub-tab" data-bs-toggle="pill" data-bs-target="#pills-pub"
                        type="button" role="tab">Publikasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-news-tab" data-bs-toggle="pill" data-bs-target="#pills-news"
                        type="button" role="tab">Berita & Artikel</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-gallery" type="button" role="tab">Galeri</button>
                </li>
            </ul>
            <div class="search-box">
                <form action="" method="GET">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="form-control border-0 shadow-sm" placeholder="Search"
                        style="width: 250px;" value="<?= htmlspecialchars($keyword ?? '') ?>">
                </form>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="tab-content" id="pills-tabContent">
            <!-- ALL CONTENT -->
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel">
                <div class="row g-4">
                    <!-- Publications (Limit 3 for "All" tab) -->
                    <?php foreach ($publications as $pub): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card content-card p-3 bg-white">
                                <div class="card-body">
                                    <p class="category-text">Publikasi</p>
                                    <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($pub['judul_publikasi']) ?>
                                    </h5>
                                    <p class="text-muted small mb-3"><?= htmlspecialchars($pub['tahun_terbit']) ?></p>
                                    <p class="card-text text-muted small mb-4">
                                        <?= htmlspecialchars(substr($pub['deskripsi'], 0, 100)) ?>...
                                    </p>
                                    <?php if (!empty($pub['link_publikasi'])): ?>
                                        <a href="<?= htmlspecialchars($pub['link_publikasi']) ?>" target="_blank"
                                            class="btn card-custom-btn btn-sm py-2">Baca</a>
                                    <?php else: ?>
                                        <button class="btn card-custom-btn btn-sm py-2" disabled>Link tidak tersedia</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- News (Limit 3) -->
                    <?php foreach ($news as $item): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card content-card p-3 bg-white">
                                <div class="content-img mb-3 rounded-3 overflow-hidden">
                                    <?php if (!empty($item['gambar_utama'])): ?>
                                        <img src="/<?= htmlspecialchars($item['gambar_utama']) ?>"
                                            class="w-100 h-100 object-fit-cover" alt="News">
                                    <?php else: ?>
                                        <i class="bi bi-newspaper display-4 text-muted"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="category-text">Berita & Artikel</div>
                                <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($item['judul']) ?></h5>
                                <p class="text-muted small mb-3"><?= date('d F Y', strtotime($item['tanggal_posting'])) ?>
                                </p>
                                <a href="/news/<?= $item['slug'] ?>"
                                    class="btn card-custom-btn btn-sm py-2 mt-auto">Selengkapnya</a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Gallery (Limit 3) -->
                    <?php foreach ($gallery as $photo): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card content-card p-3 bg-white">
                                <div class="content-img mb-3 rounded-3 overflow-hidden">
                                    <img src="/<?= htmlspecialchars($photo['file_path']) ?>"
                                        class="w-100 h-100 object-fit-cover" alt="Gallery">
                                </div>
                                <div class="category-text">Galeri</div>
                                <p class="card-text text-muted small mb-0">
                                    <?= htmlspecialchars($photo['deskripsi']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- PUBLICATIONS TAB -->
            <div class="tab-pane fade" id="pills-pub" role="tabpanel">
                <div class="row g-4">
                    <?php if (empty($publications)): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada publikasi.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($publications as $pub): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card content-card p-3 bg-white">
                                    <div class="card-body">
                                        <p class="category-text">Publikasi</p>
                                        <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($pub['judul_publikasi']) ?>
                                        </h5>
                                        <p class="text-muted small mb-3"><?= htmlspecialchars($pub['tahun_terbit']) ?></p>
                                        <p class="card-text text-muted small mb-4">
                                            <?= htmlspecialchars(substr($pub['deskripsi'], 0, 100)) ?>...
                                        </p>
                                        <?php if (!empty($pub['link_publikasi'])): ?>
                                            <a href="<?= htmlspecialchars($pub['link_publikasi']) ?>" target="_blank"
                                                class="btn card-custom-btn btn-sm py-2">Baca</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- NEWS TAB -->
            <div class="tab-pane fade" id="pills-news" role="tabpanel">
                <div class="row g-4">
                    <?php if (empty($news)): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada berita atau artikel.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($news as $item): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card content-card p-3 bg-white">
                                    <div class="content-img mb-3 rounded-3 overflow-hidden">
                                        <?php if (!empty($item['gambar_utama'])): ?>
                                            <img src="/<?= htmlspecialchars($item['gambar_utama']) ?>"
                                                class="w-100 h-100 object-fit-cover" alt="News">
                                        <?php else: ?>
                                            <i class="bi bi-newspaper display-4 text-muted"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="category-text">Berita & Artikel</div>
                                    <h5 class="card-title fw-bold mb-2"><?= htmlspecialchars($item['judul']) ?></h5>
                                    <p class="text-muted small mb-3"><?= date('d F Y', strtotime($item['tanggal_posting'])) ?>
                                    </p>
                                    <a href="/news/<?= $item['slug'] ?>"
                                        class="btn card-custom-btn btn-sm py-2 mt-auto">Selengkapnya</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- GALLERY TAB -->
            <div class="tab-pane fade" id="pills-gallery" role="tabpanel">
                <div class="row g-4">
                    <?php if (empty($gallery)): ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Belum ada foto di galeri.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($gallery as $photo): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card content-card p-3 bg-white">
                                    <div class="content-img mb-3 rounded-3 overflow-hidden">
                                        <img src="/<?= htmlspecialchars($photo['file_path']) ?>"
                                            class="w-100 h-100 object-fit-cover" alt="Gallery">
                                    </div>
                                    <div class="category-text">Galeri</div>
                                    <p class="card-text text-muted small mb-0">
                                        <?= htmlspecialchars($photo['deskripsi']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pagination (Dummy for now as per image example "1 2 3 ...") -->
        <div class="d-flex justify-content-center mt-5">
            <!-- Pagination logic can be added here if needed later -->
        </div>

    </div>

    <!-- Footer -->
    <?php include __DIR__ . '/components/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>