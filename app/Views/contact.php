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