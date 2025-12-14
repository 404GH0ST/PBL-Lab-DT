<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient mb-5" style="font-size: 40px; font-weight: bold;">Daftar Publikasi
        </h2>

        <!-- Filter -->
        <!-- Filter -->
        <div class="p-3 border shadow rounded-3">
            <form action="/publications" method="GET" id="filterForm">
                <div class="row g-2">
                    <!-- Input Pencarian -->
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" style="background-color: #F0F0F0;"
                                placeholder="Cari berdasarkan kata kunci, judul, dll." aria-label="Pencarian"
                                aria-describedby="button-search"
                                value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                            <button class="btn btn-secondary" type="submit" id="button-search">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Filter Tahun -->
                    <div class="col-lg-3">
                        <select class="form-select" name="year" aria-label="Pilih tahun"
                            style="background-color: #F0F0F0;" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            <?php foreach ($years as $y): ?>
                                <option value="<?= $y['tahun_terbit'] ?>" <?= ($filters['year'] == $y['tahun_terbit']) ? 'selected' : '' ?>>
                                    <?= $y['tahun_terbit'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Filter Penulis -->
                    <div class="col-lg-3">
                        <select class="form-select" name="author" aria-label="Pilih penulis"
                            style="background-color: #F0F0F0;" onchange="this.form.submit()">
                            <option value="">Semua Penulis</option>
                            <?php foreach ($authors as $auth): ?>
                                <option value="<?= htmlspecialchars($auth['username']) ?>"
                                    <?= ($filters['author'] == $auth['username']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($auth['nama_lengkap']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Bidang Riset (Hidden for now as no DB column) -->
                    <!-- 
                    <div class="col-lg-3 d-none">
                        <select class="form-select" aria-label="Pilih bidang"
                            style="background-color: #F0F0F0; color: #314755;">
                            <option value="" disabled="" selected>Bidang Riset</option>
                        </select>
                    </div>
                     -->
                    <!-- Urutkan -->
                    <div class="col-lg-12 mt-2">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <label class="text-muted small">Urutkan:</label>
                            <select class="form-select w-auto" name="sort" aria-label="Urutkan berdasarkan"
                                style="background-color: #F0F0F0; color: #314755;" onchange="this.form.submit()">
                                <option value="Newest" <?= ($filters['sort'] == 'Newest') ? 'selected' : '' ?>>Terbaru
                                </option>
                                <option value="Oldest" <?= ($filters['sort'] == 'Oldest') ? 'selected' : '' ?>>Terlama
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex flex-column mt-4">
            <?php if (empty($publications)): ?>
                <div class="mt-4 border rounded-4 p-4 text-center">
                    <p class="text-muted mb-0">Belum ada publikasi.</p>
                </div>
            <?php else: ?>
                <?php foreach ($publications as $pub): ?>
                    <div class="border shadow rounded-3 p-4 mb-4" style="background: #fff;">

                        <!-- Judul -->
                        <h3 class="fw-bold mb-1" style="font-size:14px;">
                            <?= htmlspecialchars($pub['judul_publikasi']) ?>
                        </h3>

                        <!-- Penulis -->
                        <p class="mb-1" style="font-size:12px; color:#575757;">
                            Penulis: <?= htmlspecialchars($pub['nama_penulis']) ?>
                        </p>

                        <p class="mb-3" style="font-size:12px; color:#575757;">
                            <?= htmlspecialchars($pub['tahun_terbit']) ?>
                        </p>

                        <!-- Deskripsi -->
                        <p class="fw-semibold mb-3" style="font-size:12px; color:#575757;">
                            <?= htmlspecialchars($pub['deskripsi'] ?? 'Tidak ada deskripsi.') ?>
                        </p>

                        <!-- Tombol Baca (lebar penuh) -->
                        <div class="rounded-1 d-flex justify-content-center align-items-center mt-3"
                            style="background:#F0F0F0; height:37px;">
                            <?php if (!empty($pub['link_publikasi'])): ?>
                                <a href="<?= htmlspecialchars($pub['link_publikasi']) ?>" target="_blank"
                                    class="fw-semibold text-vision-gradient text-decoration-none" style="font-size:14px;">
                                    Baca
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?= $pagination->renderPublic($baseUrl) ?>
        </div>

</section>