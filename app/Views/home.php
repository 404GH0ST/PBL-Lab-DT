<section id="hero">
    <div class="container d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="fw-bold mb-4 animate-fade text-hero text-white">
            Laboratorium <span style="color: #7ABC52;">Data Teknologi</span>
        </h1>
        <div class="d-flex justify-content-center align-items-center gap-3" style="font-size: 18px;">
            <a href="/publications" class="btn btn-modern btn-primary-custom animate-fade"
                style="animation-delay: .4s; text-decoration: none;">
                Jelajahi Riset
            </a>
            <a href="/gallery" class="btn btn-modern btn-outline-custom animate-fade"
                style="animation-delay: .4s; text-decoration: none;">
                Lihat Galeri
            </a>
        </div>
    </div>
</section>

<section id="about" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Tentang Kami</p>
            <h2 class="fw-bold display-5">Profil Laboratorium</h2>
        </div>

        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="/assets/images/dt-logo.png" alt="Lab Logo" class="img-fluid rounded-4 shadow-lg"
                        style="background: white; padding: 2rem;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4"
                        style="background: rgba(122, 188, 82, 0.1); z-index: -1; transform: translate(-20px, -20px);">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-modern p-4">
                    <p class="text-muted mb-4" style="text-align: justify; font-size: 1.1rem;">
                        Unit penunjang akademik di Jurusan Teknologi Informasi yang berfokus pada kegiatan pembelajaran,
                        penelitian, serta pengembangan keilmuan di bidang teknologi berbasis data. Laboratorium ini
                        menyediakan fasilitas praktikum dan riset yang mendukung penguasaan pengetahuan serta
                        keterampilan mahasiswa
                        dalam pengolahan data, analisis big data, kecerdasan buatan, dan machine learning.
                    </p>
                    <p class="text-muted mb-4" style="text-align: justify; font-size: 1.1rem;">
                        Selain sebagai sarana praktikum, Laboratorium Teknologi Data juga berperan sebagai pusat
                        penelitian dan pengembangan
                        bagi dosen maupun mahasiswa.
                    </p>
                    <a href="/about" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                        Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="team" style="background: #f8f9fa;" class="section-padding">
    <div class="container text-center">
        <!-- Title -->
        <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Anggota Tim</p>
        <h2 class="fw-bold display-5 mb-5">Meet Our Team</h2>

        <!-- Team Members -->

        <!-- Head of Lab -->
        <?php if (!empty($headOfLab)): ?>
            <div class="row justify-content-center mb-5">
                <?php foreach ($headOfLab as $member): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="/member/<?= $member['id_anggota'] ?>" class="text-decoration-none text-dark">
                            <div class="card-modern h-100 text-center p-4 transition-hover border-primary border-2">
                                <?php if (!empty($member['foto_profil'])): ?>
                                    <img src="/uploads/foto_profil/<?= htmlspecialchars($member['foto_profil']) ?>"
                                        class="rounded-circle mb-3 shadow-lg"
                                        style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #7ABC52;">
                                <?php else: ?>
                                    <div class="rounded-circle mb-3 shadow-lg mx-auto d-flex align-items-center justify-content-center bg-primary text-white"
                                        style="width: 180px; height: 180px; border: 4px solid #7ABC52; font-size: 3.5rem;">
                                        <?= strtoupper(substr($member['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="fw-bold mb-1" style="font-size: 1.5rem;">
                                    <?= htmlspecialchars($member['nama_lengkap']) ?>
                                </h3>
                                <p class="text-primary fw-bold mb-0" style="font-size: 1rem;">Kepala Laboratorium</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Lab Members -->
        <?php if (!empty($labMembers)): ?>
            <div class="row justify-content-center g-4">
                <?php foreach ($labMembers as $member): ?>
                    <div class="col-md-6 col-lg-3">
                        <a href="/member/<?= $member['id_anggota'] ?>" class="text-decoration-none text-dark">
                            <div class="card-modern h-100 text-center p-4 transition-hover">
                                <?php if (!empty($member['foto_profil'])): ?>
                                    <img src="/uploads/foto_profil/<?= htmlspecialchars($member['foto_profil']) ?>"
                                        class="rounded-circle mb-3 shadow-sm"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f8f9fa;">
                                <?php else: ?>
                                    <div class="rounded-circle mb-3 shadow-sm mx-auto d-flex align-items-center justify-content-center bg-secondary text-white"
                                        style="width: 150px; height: 150px; border: 4px solid #f8f9fa; font-size: 3rem;">
                                        <?= strtoupper(substr($member['nama_lengkap'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                                <h4 class="fw-bold mb-1" style="font-size: 1.25rem;">
                                    <?= htmlspecialchars($member['nama_lengkap']) ?>
                                </h4>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Anggota Laboratorium</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Button -->
        <a href="/about" class="btn btn-modern btn-primary-custom mt-5" style="text-decoration: none;">
            Lihat Semua Anggota
        </a>

    </div>
</section>

<section id="visimisi" class="section-padding">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4">
                <div class="pe-lg-4">
                    <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Visi & Misi</p>
                    <h2 class="fw-bold display-5 mb-4">Visi & Misi Kami</h2>
                    <p class="text-muted mb-4">
                        Kami berkomitmen untuk menjadi pusat unggulan dalam riset dan pengembangan teknologi data.
                    </p>
                    <a href="/about" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                        Selengkapnya
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-4">

                    <!-- Vision Card -->
                    <div class="card-modern p-4 mb-4 bg-white shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 50px; height: 50px; background-color: #7ABC52; color: white;">
                                <i class="bi bi-lightning-fill fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-0">Visi</h3>
                        </div>
                        <div class="p-4 rounded-3" style="background-color: #E8F5E9;">
                            <div class="text-black mb-0" style="line-height: 1.7;">
                                <?= $visi['isi_konten'] ?? 'Visi belum tersedia.' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Mission Card -->
                    <div class="card-modern p-4 bg-white shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 50px; height: 50px; background-color: #7ABC52; color: white;">
                                <i class="bi bi-lightning-fill fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-0">Misi</h3>
                        </div>

                        <?php
                        // Parse Mission Content to split by points
                        $missionPoints = [];
                        $content = $misi['isi_konten'] ?? '';

                        if (strpos($content, '<li') !== false) {
                            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $content, $matches);
                            $missionPoints = $matches[1];
                        } elseif (strpos($content, '<p') !== false) {
                            preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
                            $missionPoints = $matches[1];
                        }
                        ?>

                        <?php if (!empty($missionPoints)): ?>
                            <?php $idx = 1;
                            foreach ($missionPoints as $point): ?>
                                <div class="p-3 rounded-3 mb-2" style="background-color: #E8F5E9;">
                                    <div class="text-black mb-0 d-flex" style="line-height: 1.7;">
                                        <span class="fw-bold me-2"><?= $idx++ ?>.</span>
                                        <div><?= strip_tags($point, '<b><strong><i><em><u><span>') ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="p-4 rounded-3" style="background-color: #E8F5E9;">
                                <div class="text-black mb-0" style="line-height: 1.7;">
                                    <?= $misi['isi_konten'] ?? 'Misi belum tersedia.' ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section id="facilities" style="background: #fcfcfc;" class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Fasilitas</p>
                <h2 class="fw-bold display-5">Fasilitas Laboratorium</h2>
            </div>
            <a href="/facility" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                Lihat Semua
            </a>
        </div>

        <div class="row g-4">
            <?php if (!empty($facilities)): ?>
                <?php foreach ($facilities as $f): ?>
                    <div class="col-12 col-md-6 col-lg-4">
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
                                    <?= htmlspecialchars(substr($f['deskripsi'] ?? '', 0, 100)) ?>...
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
    </div>
</section>

<section id="activities" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Kegiatan</p>
            <h2 class="fw-bold display-5">Kegiatan & Proyek</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($activities as $activity): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-modern h-100 p-4 text-center transition-hover">
                        <div class="mb-4">
                            <i class="<?= htmlspecialchars($activity['gambar'] ?? 'bi bi-activity') ?> display-4"
                                style="color: #7ABA54;"></i>
                        </div>
                        <h4 class="fw-bold mb-3"><?= htmlspecialchars($activity['judul_kegiatan']) ?></h4>
                        <p class="text-muted mb-0">
                            <?= htmlspecialchars($activity['deskripsi']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12 text-center mt-4">
                <a href="/about" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

<section id="courses" style="background: #fcfcfc;" class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Akademik</p>
            <h2 class="fw-bold display-5">Perkuliahan Terkait</h2>
        </div>
        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-modern h-100 p-4 text-center transition-hover">
                        <div class="mb-4">
                            <i class="<?= htmlspecialchars($course['gambar'] ?? 'bi bi-book') ?> display-4"
                                style="color: #7ABA54;"></i>
                        </div>
                        <h4 class="fw-bold mb-3"><?= htmlspecialchars($course['judul_perkuliahan']) ?></h4>
                        <p class="text-muted mb-0">
                            <?= htmlspecialchars($course['deskripsi']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12 text-center mt-4">
                <a href="/about" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</section>

<section id="focusRiset" style="background: #19586E;" class="section-padding">
    <div class="container text-center">
        <div class="mb-5">
            <p class="fw-bold text-uppercase text-white-50" style="letter-spacing: 1px;">Riset Kami</p>
            <h2 class="fw-bold display-5 text-white">Fokus Riset</h2>
        </div>
        <div class="row justify-content-center g-4">
            <?php if (!empty($focusList)): ?>
                <?php foreach ($focusList as $f): ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="d-flex align-items-center justify-content-center p-3 text-center h-100"
                            style="border: 1px solid white; border-radius: 8px; color: white; min-height: 60px;">
                            <h5 class="fw-bold mb-0 text-white" style="font-size: 1rem;"><?= htmlspecialchars($f['bidang']) ?>
                            </h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-white-50">Belum ada fokus riset yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="publication" class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Publikasi</p>
                <h2 class="fw-bold display-5">Publikasi Terbaru</h2>
            </div>
            <a href="/publications" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                Selengkapnya
            </a>
        </div>

        <div class="row g-4">
            <?php if (empty($recentPublications)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada publikasi.</p>
                </div>
            <?php else: ?>
                <?php foreach ($recentPublications as $pub): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-modern h-100 d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <?php
                                    // Calculate max citations and get the ID of the winner (sorted by citations DESC, year DESC)
                                    $mostCitedId = null;
                                    if (!empty($mostCitedPublications)) {
                                        $mostCitedId = $mostCitedPublications[0]['id_publikasi'];
                                    }

                                    // Check if this publication is the specific winner
                                    $isMostCited = ($pub['id_publikasi'] == $mostCitedId);

                                    if ($isMostCited):
                                        ?>
                                        <span class="badge rounded-pill"
                                            style="background: #d1e7dd; color: #0f5132; font-size: 0.75rem;">
                                            Most Cited
                                        </span>
                                    <?php else: ?>
                                        <!-- Spacer to keep layout consistent if needed, or just empty -->
                                        <div></div>
                                    <?php endif; ?>
                                </div>

                                <h5 class="card-title fw-bold mb-3" style="color: #314755; line-height: 1.4;">
                                    <?= htmlspecialchars($pub['judul_publikasi']) ?>
                                </h5>

                                <div class="mt-auto mb-4">
                                    <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                                        <i class="bi bi-calendar3 me-2"></i><?= htmlspecialchars($pub['tahun_terbit']) ?>
                                    </p>
                                    <span class="badge rounded-pill bg-secondary bg-opacity-25 text-secondary">
                                        <?= $pub['citation_count'] ?? 0 ?> Citations
                                    </span>
                                </div>

                                <a href="<?= htmlspecialchars($pub['link_publikasi'] ?? '#') ?>" target="_blank"
                                    class="btn btn-modern btn-outline-custom w-100 text-center"
                                    style="border-color: #19586E; color: #19586E;">Baca Publikasi</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="gallery" style="background: #f8f9fa;" class="section-padding">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Galeri</p>
                <h2 class="fw-bold display-5">Dokumentasi Kegiatan</h2>
            </div>
            <a href="/gallery" class="btn btn-modern btn-primary-custom" style="text-decoration: none;">
                Lihat Semua
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($gallery as $photo): ?>
                <div class="col-6 col-lg-4">
                    <div class="card-modern overflow-hidden p-0 gallery-item">
                        <img src="<?= htmlspecialchars($photo['file_path']) ?>" alt="Gallery Image" class="img-fluid w-100"
                            style="object-fit: cover; height: 250px; transition: transform 0.5s ease;">
                        <div class="gallery-overlay">
                            <p class="mb-0 fw-semibold"><?= htmlspecialchars($photo['deskripsi'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="contactUs" class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <p class="fw-bold text-uppercase" style="color: #7ABC52; letter-spacing: 1px;">Kontak</p>
                <h2 class="fw-bold display-5 mb-4">Mari wujudkan sesuatu yang bermakna bersama</h2>
                <p class="text-muted mb-5" style="font-size: 1.1rem;">
                    Kami menyambut kolaborasi dengan peneliti, mahasiswa, dan mitra industri. Hubungi kami untuk
                    mengetahui bagaimana kita dapat berkolaborasi menciptakan solusi data yang berdampak.
                </p>

                <div class="d-flex align-items-center gap-4 p-4 rounded-4"
                    style="background: rgba(122, 188, 82, 0.05);">
                    <div class="feature-icon-box mb-0 bg-white shadow-sm">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark">Email Kami</span>
                        <span
                            class="text-muted"><?= htmlspecialchars($infoLab['email'] ?? 'lab.datatech@gmail.com') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-modern p-5">
                    <?php if (!empty($_SESSION['flash_success'])): ?>
                        <div class="alert alert-success mt-3">
                            <?= $_SESSION['flash_success'] ?>
                        </div>
                        <?php unset($_SESSION['flash_success']); ?>
                    <?php endif; ?>
                    <form action="/contact/send" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control p-3 bg-light border-0" name="name" id="name"
                                    placeholder="John Doe">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Alamat Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control p-3 bg-light border-0" name="email" id="email"
                                    placeholder="john@example.com">
                            </div>
                            <div class="col-12">
                                <label for="organization" class="form-label fw-bold">Institusi/Organisasi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control p-3 bg-light border-0" name="organization"
                                    id="organization" placeholder="Universitas / Perusahaan">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-bold">Bagaimana kami dapat membantu?</label>
                                <textarea class="form-control p-3 bg-light border-0" name="message" id="message"
                                    rows="5" placeholder="Ceritakan kebutuhan atau proyek Anda..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-modern btn-primary-custom w-100 py-3">
                                    Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>