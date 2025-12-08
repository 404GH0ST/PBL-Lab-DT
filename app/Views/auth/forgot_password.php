<div class="auth-card">
    <div class="text-center mb-4">
        <h1 class="auth-title">Lupa Password</h1>
        <p class="auth-subtitle">Masukkan email Anda untuk mereset password</p>

        <?php if (isset($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['flash_success'];
                unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors['email'])): ?>
            <div class="alert alert-danger">
                <?= $errors['email']; ?>
            </div>
        <?php endif; ?>
    </div>

    <form action="/forgot-password" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label text-sm fw-medium text-gray-700">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            Kirim Link Reset
        </button>

        <div class="text-center">
            <a href="/login" class="text-sm text-decoration-none" style="color: #4f46e5;">Kembali ke Login</a>
        </div>
    </form>
</div>