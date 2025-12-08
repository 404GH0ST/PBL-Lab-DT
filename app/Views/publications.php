<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient mb-5" style="font-size: 40px; font-weight: bold;">Daftar Publikasi
        </h2>

        <!-- Filter -->
        <div class="p-3 border shadow rounded-3">
            <form action="">
                <div class="row g-2">
                    <!-- Input Pencarian -->
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text" class="form-control" style="background-color: #F0F0F0;"
                                placeholder="Cari berdasarkan kata kunci, judul, dll." aria-label="Pencarian"
                                aria-describedby="button-search">
                            <button class="btn btn-secondary" type="submit" id="button-search">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Filter Tahun -->
                    <div class="col-lg-3">
                        <select class="form-select" aria-label="Pilih tahun" style="background-color: #F0F0F0;">
                            <option value="" disabled="" selected>Tahun</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <!-- Filter Penulis (nanti pakai select2) -->
                    <div class="col-lg-3">
                        <select class="form-select" aria-label="Pilih penulis" style="background-color: #F0F0F0;">
                            <option value="" disabled="" selected>Penulis</option>
                            <option value="Fabrizio">Fabrizio</option>
                            <option value="Romano">Romano</option>
                        </select>
                    </div>
                    <!-- Bidang Riset -->
                    <div class="col-lg-3">
                        <select class="form-select" aria-label="Pilih bidang"
                            style="background-color: #F0F0F0; color: #314755;">
                            <option value="" disabled="" selected>Bidang Riset</option>
                            <option value="Malang">Malang</option>
                            <option value="Jakarta">Jakarta</option>
                        </select>
                    </div>
                    <!-- Urutkan -->
                    <div class="col-lg-3">
                        <select class="form-select" aria-label="Urutkan berdasarkan"
                            style="background-color: #F0F0F0; color: #314755;">
                            <option value="" disabled="" selected>Urutkan: Terbaru</option>
                            <option value="Newest">Terbaru</option>
                            <option value="Oldest">Terlama</option>
                        </select>
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