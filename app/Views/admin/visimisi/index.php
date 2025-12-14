<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-1 fw-bold">Manajemen Profil Lab</h5>
        <p class="text-muted small mb-0">Perbarui Visi dan Misi</p>
    </div>
    <form action="/admin/visimisi" method="POST" id="labProfileForm">
        <div class="card-body">
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h6 class="fw-bold mb-0">Visi</h6>
                    <?php
                    $visiData = null;
                    foreach ($visiMisi as $item) {
                        if ($item['jenis_konten'] === 'visi') {
                            $visiData = $item;
                            break;
                        }
                    }

                    if ($visiData) {
                        $statusClass = match ($visiData['status'] ?? 'pending') {
                            'approved' => 'bg-success-subtle text-success',
                            'rejected' => 'bg-danger-subtle text-danger',
                            default => 'bg-warning-subtle text-warning'
                        };
                        $statusLabel = match ($visiData['status'] ?? 'pending') {
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            default => 'Tertunda'
                        };
                        echo "<span class='badge {$statusClass} border'>{$statusLabel}</span>";
                    }
                    ?>
                </div>

                <?php if (($visiData['status'] ?? '') === 'rejected' && !empty($visiData['catatan_admin'])): ?>
                    <div class="alert alert-danger bg-danger-subtle border-danger text-danger p-3 mb-3 text-sm">
                        <div class="d-flex gap-2">
                            <i class="bi bi-exclamation-circle mt-1"></i>
                            <div>
                                <strong class="d-block mb-1">Catatan Penolakan:</strong>
                                <?= nl2br(htmlspecialchars($visiData['catatan_admin'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <textarea class="form-control" name="visi" id="visi_editor" rows="5"
                    placeholder="Masukkan pernyataan visi laboratorium"><?= $visiData ? htmlspecialchars($visiData['isi_konten']) : '' ?></textarea>
                <small class="text-muted d-block mt-2">Pernyataan visi utama laboratorium.</small>
            </div>

            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <h6 class="fw-bold mb-0">Misi</h6>
                    <?php
                    $misiData = null;
                    foreach ($visiMisi as $item) {
                        if ($item['jenis_konten'] === 'misi') {
                            $misiData = $item;
                            break;
                        }
                    }

                    if ($misiData) {
                        $statusClass = match ($misiData['status'] ?? 'pending') {
                            'approved' => 'bg-success-subtle text-success',
                            'rejected' => 'bg-danger-subtle text-danger',
                            default => 'bg-warning-subtle text-warning'
                        };
                        $statusLabel = match ($misiData['status'] ?? 'pending') {
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                            default => 'Tertunda'
                        };
                        echo "<span class='badge {$statusClass} border'>{$statusLabel}</span>";
                    }
                    ?>
                </div>

                <?php if (($misiData['status'] ?? '') === 'rejected' && !empty($misiData['catatan_admin'])): ?>
                    <div class="alert alert-danger bg-danger-subtle border-danger text-danger p-3 mb-3 text-sm">
                        <div class="d-flex gap-2">
                            <i class="bi bi-exclamation-circle mt-1"></i>
                            <div>
                                <strong class="d-block mb-1">Catatan Penolakan:</strong>
                                <?= nl2br(htmlspecialchars($misiData['catatan_admin'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <textarea class="form-control" name="misi" id="misi_editor" rows="5"
                    placeholder="Masukkan pernyataan misi laboratorium"><?= $misiData ? htmlspecialchars($misiData['isi_konten']) : '' ?></textarea>
                <small class="text-muted d-block mt-2">Poin-poin misi terperinci.</small>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" id="saveBtn">
                <i class="bi bi-check2 me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        // --- INISIALISASI SUMMERNOTE ---
        $('#visi_editor').summernote({
            placeholder: 'Masukkan Visi...',
            tabsize: 2,
            height: 200
        });
        $('#misi_editor').summernote({
            placeholder: 'Masukkan Misi...',
            tabsize: 2,
            height: 200
        });
    });
</script>