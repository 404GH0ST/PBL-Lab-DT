<div class="auth-card">
    <div class="text-center mb-4">
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Masukkan password baru Anda</p>

        <?php if (isset($errors['password'])): ?>
            <div class="alert alert-danger">
                <?= $errors['password']; ?>
            </div>
        <?php endif; ?>
    </div>

    <form action="/reset-password" method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <div class="mb-3">
            <label for="password" class="form-label text-sm fw-medium text-gray-700">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label text-sm fw-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            Reset Password
        </button>
    </form>
</div>