<div class="auth-card">
    <div class="text-center mb-4">
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Please sign in to your account</p>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>

    <form action="/login" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label text-sm fw-medium text-gray-700">Username</label>
            <input type="username" class="form-control" id="username" name="username" placeholder="admin" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-sm fw-medium text-gray-700">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label text-sm text-gray-600" for="remember">
                    Remember me
                </label>
            </div>
            <a href="#" class="text-sm text-decoration-none" style="color: #4f46e5;">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary">
            Sign in
        </button>
    </form>
</div>