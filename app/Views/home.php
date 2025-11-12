<?php ob_start(); ?>

<h1><?= htmlspecialchars($title ?? 'Welcome') ?></h1>

<p style="font-size: 18px; margin: 20px 0; color: #666;">
    <?= htmlspecialchars($message ?? '') ?>
</p>

<div style="margin: 40px 0;">
    <h2 style="color: #667eea; margin-bottom: 20px;">Features</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="padding: 20px; border: 2px solid #667eea; border-radius: 8px;">
            <h3 style="color: #667eea; margin-bottom: 10px;">Simple & Clear</h3>
            <p>No magic, no ORM. Write plain SQL queries - see exactly what's happening!</p>
        </div>

        <div style="padding: 20px; border: 2px solid #764ba2; border-radius: 8px;">
            <h3 style="color: #764ba2; margin-bottom: 10px;">Robust Router</h3>
            <p>Full-featured router with route parameters, grouping, and middleware support.</p>
        </div>

        <div style="padding: 20px; border: 2px solid #667eea; border-radius: 8px;">
            <h3 style="color: #667eea; margin-bottom: 10px;">Easy to Learn</h3>
            <p>Clear code flow from route → controller → model → database. Perfect for beginners!</p>
        </div>

        <div style="padding: 20px; border: 2px solid #764ba2; border-radius: 8px;">
            <h3 style="color: #764ba2; margin-bottom: 10px;">PostgreSQL Ready</h3>
            <p>Configured for PostgreSQL with simple PDO wrapper. Easy to switch databases!</p>
        </div>
    </div>
</div>

<div style="margin: 40px 0; padding: 20px; background: #f8f9fa; border-radius: 8px;">
    <h2 style="color: #667eea; margin-bottom: 15px;">Quick Start</h2>
    <ol style="margin-left: 20px; color: #666;">
        <li style="margin: 10px 0;">Install: <code style="background: white; padding: 2px 8px; border-radius: 4px;">composer dump-autoload</code></li>
        <li style="margin: 10px 0;">Configure PostgreSQL in <code style="background: white; padding: 2px 8px; border-radius: 4px;">config/app.php</code></li>
        <li style="margin: 10px 0;">Define routes in <code style="background: white; padding: 2px 8px; border-radius: 4px;">routes/web.php</code></li>
        <li style="margin: 10px 0;">Create controllers with <code style="background: white; padding: 2px 8px; border-radius: 4px;">$this->loadModel()</code></li>
        <li style="margin: 10px 0;">Write plain SQL in your models!</li>
    </ol>
</div>

<div style="margin: 40px 0; padding: 20px; background: #e3f2fd; border-radius: 8px;">
    <h2 style="color: #667eea; margin-bottom: 15px;">Code Flow Example</h2>
    <pre style="background: white; padding: 15px; border-radius: 4px; overflow-x: auto; line-height: 1.6;"><code style="color: #333; font-size: 14px;">// 1. Route
$router->get('/api/users', [HomeController::class, 'users']);

// 2. Controller
public function users() {
    $userModel = $this->loadModel(User::class);
    $users = $userModel->getAllUsers();
    return $this->json(['users' => $users]);
}

// 3. Model
public function getAllUsers() {
    $sql = "SELECT * FROM users";
    return $this->db->query($sql);
}</code></pre>
    <p style="margin-top: 15px; color: #666;">
        <strong>That's it!</strong> No ORM, no complex abstractions. Just simple, clear code flow.
    </p>
</div>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/layout.php'; ?>
