<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <h2 class="text-vision-gradient" style="font-size: 40px; font-weight: bold;">Tentang Kami
        </h2>

        <h2 class="fw-bold mt-4" style="color: #575757; font-size: 32px;">Anggota Laboratorium</h2>
        <div class="row g-4 mb-5">
            <?php foreach ($members as $member): ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card shadow rounded-3 p-3 animation-card h-100">
                        <div class="text-center mb-3 mt-4">
                            <?php if (!empty($member['foto_profil'])): ?>
                                <img src="/uploads/foto_profil/<?= htmlspecialchars($member['foto_profil']) ?>"
                                    alt="<?= htmlspecialchars($member['nama_lengkap']) ?>"
                                    class="mx-auto d-block rounded-circle"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                <div class="mx-auto d-flex align-items-center justify-content-center bg-light rounded-circle"
                                    style="width: 100px; height: 100px;">
                                    <i class="bi bi-person display-1 text-secondary"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title all-text-gradient fw-semibold mt-3 mb-1">
                                <a href="/member/<?= $member['id_anggota'] ?>"
                                    class="text-decoration-none text-vision-gradient stretched-link">
                                    <?= htmlspecialchars($member['nama_lengkap']) ?>
                                </a>
                            </h5>
                            <p class="card-text m-0 mb-2" style="color: #5F983C; font-size: 12px;">
                                <?= htmlspecialchars($member['role'] === 'admin' ? 'Kepala Laboratorium' : 'Anggota Laboratorium') ?>
                            </p>
                            <?php if (!empty($member['bio'])): ?>
                                <p class="card-text text-muted mb-3" style="font-size: 14px;">
                                    <?= htmlspecialchars(substr($member['bio'], 0, 100)) ?>
                                    <?= strlen($member['bio']) > 100 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-center gap-2 mt-2"
                                style="color: #575757;">
                                <i class="bi bi-envelope"></i>
                                <p class="card-text m-0" style="font-size: 12px;"><?= htmlspecialchars($member['email']) ?>
                                </p>
                            </div>
                            <?php if (!empty($member['nip_nim'])): ?>
                                <div class="d-flex align-items-center justify-content-center gap-2" style="color: #575757;">
                                    <i class="bi bi-card-heading"></i>
                                    <p class="card-text m-0" style="font-size: 12px;">
                                        <?= htmlspecialchars($member['nip_nim']) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="fw-bold mt-4" style="color: #575757; font-size: 32px;">Kegiatan & Proyek</h2>
        <div class="row g-4 mb-5">
            <?php foreach ($activities as $activity): ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card shadow rounded-3 p-3 animation-card h-100">
                        <div class="text-center mb-3 mt-4">
                            <i class="<?= htmlspecialchars($activity['gambar'] ?? 'bi bi-activity') ?> display-4"
                                style="color: #7ABA54;"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title all-text-gradient fw-semibold my-3">
                                <?= htmlspecialchars($activity['judul_kegiatan']) ?>
                            </h5>
                            <p class="card-text" style="color: #575757;">
                                <?= htmlspecialchars($activity['deskripsi']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="fw-bold mt-4" style="color: #575757; font-size: 32px;">Perkuliahan Terkait</h2>
        <div class="row g-4 mb-5 fade-in-up">
            <?php foreach ($courses as $course): ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card shadow rounded-3 p-3 animation-card h-100">
                        <div class="text-center mb-3 mt-4">
                            <i class="<?= htmlspecialchars($course['gambar'] ?? 'bi bi-book') ?> display-4"
                                style="color: #7ABA54;"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title all-text-gradient fw-semibold my-3">
                                <?= htmlspecialchars($course['judul_perkuliahan']) ?>
                            </h5>
                            <p class="card-text" style="color: #575757;">
                                <?= htmlspecialchars($course['deskripsi']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>