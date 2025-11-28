<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-1 fw-bold">Lab Profile Management</h5>
        <p class="text-muted small mb-0">Update Visi, Misi</p>
    </div>
    <form action="/admin/visimisi" method="POST" id="labProfileForm">
        <div class="card-body">
            <!-- Visi Section -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Visi</h6>
                <?php 
                    $visiData = null;
                    foreach ($visiMisi as $item) {
                        if ($item['jenis_konten'] === 'visi') {
                            $visiData = $item;
                            break;
                        }
                    }
                ?>
                <textarea class="form-control" name="visi" id="visi_textarea" rows="5" placeholder="Masukkan pernyataan visi laboratorium"><?= $visiData ? htmlspecialchars($visiData['isi_konten']) : '' ?></textarea>
                <small class="text-muted d-block mt-2">The main vision statement of the laboratory.</small>
            </div>

            <!-- Misi Section -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Misi</h6>
                <?php 
                    $misiData = null;
                    foreach ($visiMisi as $item) {
                        if ($item['jenis_konten'] === 'misi') {
                            $misiData = $item;
                            break;
                        }
                    }
                ?>
                <textarea class="form-control" name="misi" id="misi_textarea" rows="5" placeholder="Masukkan pernyataan misi laboratorium"><?= $misiData ? htmlspecialchars($misiData['isi_konten']) : '' ?></textarea>
                <small class="text-muted d-block mt-2">Detailed mission points.</small>
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2 me-1"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-warning">Konfirmasi Perubahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Anda telah melakukan perubahan pada Visi dan/atau Misi. Apakah Anda yakin ingin menyimpan perubahan ini?</p>
                <div class="alert alert-warning-subtle text-warning mt-3 small p-2">
                    Pastikan konten sudah benar, karena perubahan akan langsung dipublikasikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning px-4" id="confirmSaveChangesBtn">
                    <i class="bi bi-check2"></i> Simpan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    // Variabel Global untuk menyimpan data sebelum AJAX dieksekusi
    let dataToSave = {
        visi: null,
        misi: null
    };

    // Variabel Global untuk mendeteksi perubahan
    let originalVisi = '';
    let originalMisi = '';

    $(document).ready(function () {
        // --- 0. INISIALISASI SUMMERNOTE ---
        $('#visi_editor').summernote({
            placeholder: 'Masukkan Visi...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'hr']]
            ],
            // Event onchange diperlukan untuk memicu updateSubmitButtonState
            callbacks: {
                onChange: function(contents, $editable) {
                    updateSubmitButtonState();
                }
            }
        });
        
        $('#misi_editor').summernote({
            placeholder: 'Masukkan Misi...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'hr']]
            ],
            // Event onchange diperlukan untuk memicu updateSubmitButtonState
            callbacks: {
                onChange: function(contents, $editable) {
                    updateSubmitButtonState();
                }
            }
        });
        // --- END SUMMERNOTE INIT ---


        // --- 1. INISIALISASI DATA AWAL ---
        // PENTING: Gunakan .summernote('code') untuk mendapatkan konten HTML
        originalVisi = $('#visi_editor').summernote('code'); 
        originalMisi = $('#misi_editor').summernote('code');

        updateSubmitButtonState();

        // --- 2. FUNGSI HELPER VISUAL/VALIDASI ---

        // Fungsi ini disederhanakan karena Summernote tidak lagi menggunakan .val()
        function validateForm(form) {
            let isValid = true;
            // Summernote tidak perlu validasi required jika datanya diambil melalui code()
            // Kita pastikan saja kontennya tidak kosong
            const visiContent = $('#visi_editor').summernote('isEmpty') ? '' : $('#visi_editor').summernote('code');
            const misiContent = $('#misi_editor').summernote('isEmpty') ? '' : $('#misi_editor').summernote('code');
            
            if ($.trim(visiContent) === '' || $.trim(misiContent) === '') {
                isValid = false;
                // Di Summernote, validasi visual lebih sulit, kita bisa menggunakan pesan error inline.
                // Untuk saat ini, kita hanya mengembalikan status validasi.
            }
            return isValid;
        }

        function updateSubmitButtonState() {
            // PENTING: Gunakan .summernote('code') untuk mendapatkan konten HTML saat ini
            const currentVisi = $('#visi_editor').summernote('code');
            const currentMisi = $('#misi_editor').summernote('code');
            
            const hasChanged = currentVisi !== originalVisi || currentMisi !== originalMisi;
            const $btn = $('#saveBtn'); 

            if (hasChanged) {
                $btn.removeClass('btn-primary btn-danger').addClass('btn-warning');
                $btn.html('<i class="bi bi-exclamation-triangle-fill"></i> Ada Perubahan - Simpan');
                $btn.prop('disabled', false);
            } else {
                $btn.removeClass('btn-warning btn-danger').addClass('btn-primary');
                $btn.html('<i class="bi bi-check2"></i> Save Changes');
                $btn.prop('disabled', true); 
            }
        }

        // --- 3. SUBMISSION FORM (Memicu Modal Konfirmasi) ---

        $('#labProfileForm').on('submit', function (e) {
            e.preventDefault();

            // PENTING: Ambil konten dari Summernote
            const currentVisi = $('#visi_editor').summernote('code');
            const currentMisi = $('#misi_editor').summernote('code');

            // 1. Validasi
            if (!validateForm(this)) {
                // Di sini Anda bisa menambahkan feedback visual jika diperlukan
                return;
            }

            // 2. Cek Perubahan
            if (currentVisi === originalVisi && currentMisi === originalMisi) {
                return; // Tidak ada perubahan, hentikan
            }
            
            // 3. Simpan data sementara & Tampilkan Modal
            dataToSave.visi = currentVisi;
            dataToSave.misi = currentMisi;

            const saveModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('confirmSaveModal'));
            saveModal.show();
        });


        // --- 4. EKSEKUSI PENYIMPANAN (Dipanggil oleh Tombol Modal) ---
        
        $('#confirmSaveChangesBtn').on('click', function() {
            const saveModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('confirmSaveModal'));
            saveModal.hide();
            
            executeSaveChanges(dataToSave.visi, dataToSave.misi);
        });

        // Fungsi Inti untuk melakukan AJAX (dengan perbaikan key & response)
        function executeSaveChanges(visi, misi) {
            const $btn = $('#saveBtn');
            const originalHtml = $btn.html(); // Gunakan originalHtml untuk menyimpan HTML lengkap

            // Set Loading State
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');

            // Kirim 2 permintaan AJAX paralel
            const visiRequest = $.post('/admin/visimisi', {
                jenis_konten: 'visi', 
                isi_konten: visi      
            });
            const misiRequest = $.post('/admin/visimisi', {
                jenis_konten: 'misi', 
                isi_konten: misi      
            });

            $.when(visiRequest, misiRequest)
                .done(function (visiResponse, misiResponse) {
                    // SUKSES: Langsung muat ulang halaman sebagai konfirmasi
                    window.location.reload();
                })
                .fail(function (xhr, status, error) {
                    // GAGAL: Tampilkan feedback visual di tombol selama 3 detik
                    
                    // Kembalikan tombol ke keadaan error
                    $btn.removeClass('btn-warning').addClass('btn-danger').html('<i class="bi bi-x-circle-fill"></i> Gagal! Coba Lagi.');
                    console.error('AJAX Save Failed:', xhr.status, status, error); 

                    // Kembalikan tombol ke keadaan awal setelah jeda
                    setTimeout(() => {
                        updateSubmitButtonState(); 
                    }, 3000);
                });
        }
    });
</script>