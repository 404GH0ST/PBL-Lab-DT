<section class="bg-white" style="min-height: 100vh;">
    <div class="container py-5">
        <?php if (empty($article)): ?>
            <div class="text-center py-5 text-muted">Berita tidak ditemukan.</div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <a href="/news" class="btn btn-outline-secondary mb-3">← Kembali ke Berita</a>
                    <h1 class="fw-bold"><?= htmlspecialchars($article['judul']) ?></h1>
                    <p class="text-muted small">Diposting oleh <strong><?= htmlspecialchars($article['penulis']) ?></strong> pada <?= date('d F Y', strtotime($article['tanggal_posting'] ?? 'now')) ?></p>
                    <?php if (!empty($article['gambar_utama'])): ?>
                        <div class="mb-4">
                            <img src="/<?= htmlspecialchars($article['gambar_utama']) ?>" alt="<?= htmlspecialchars($article['judul']) ?>" class="img-fluid rounded-3 w-100" style="max-height:480px; object-fit:cover;">
                        </div>
                    <?php endif; ?>

                    <div class="mb-5 lh-lg" style="line-height: 1.8; font-size: 1.05rem;">
                        <?= nl2br(htmlspecialchars($article['isi_berita'])) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
