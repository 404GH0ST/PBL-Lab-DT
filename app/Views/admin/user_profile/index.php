<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 fw-bold text-dark">Profil Saya</h5>
                <p class="text-muted small mb-0">Perbarui informasi pribadi Anda</p>
            </div>
            <div class="card-body">


                <form action="/admin/my-profile/update" method="POST" enctype="multipart/form-data">

                    <div class="text-center mb-4">
                        <div class="avatar-preview mb-3"
                            style="width: 100px; height: 100px; margin: 0 auto; overflow: hidden; border-radius: 50%;">
                            <?php if (!empty($user['foto_profil'])): ?>
                                <img src="/uploads/foto_profil/<?= htmlspecialchars($user['foto_profil']) ?>" alt="Profile"
                                    class="w-100 h-100 object-fit-cover" id="avatarPreview">
                            <?php else: ?>
                                <div class="bg-light text-primary w-100 h-100 d-flex align-items-center justify-content-center border"
                                    style="font-size: 2rem;">
                                    <?= strtoupper(substr($user['nama_lengkap'], 0, 2)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="file" class="form-control d-none" id="foto_profil" name="foto_profil"
                            accept="image/*" onchange="previewImage(this)">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="document.getElementById('foto_profil').click()">
                            <i class="bi bi-camera"></i> Ganti Foto
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                            value="<?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nip_nim" class="form-label">NIP / NIM</label>
                            <input type="text" class="form-control" id="nip_nim" name="nip_nim"
                                value="<?= htmlspecialchars($user['nip_nim'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio (Opsional)</label>
                        <textarea class="form-control" id="bio" name="bio"
                            rows="3"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">Ubah Kata Sandi</h6>
                    <p class="text-muted small mb-3">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                let preview = document.getElementById('avatarPreview');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    // If there was no image before/div placeholder
                    const container = document.querySelector('.avatar-preview');
                    container.innerHTML = `<img src="${e.target.result}" alt="Profile" class="w-100 h-100 object-fit-cover" id="avatarPreview">`;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>