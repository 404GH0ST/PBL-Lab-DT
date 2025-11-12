<?php

/**
 * Web Routes
 * Define your application routes here
 */

use App\Controllers\HomeController;
use Core\Middleware\AuthMiddleware;
use Core\Middleware\CorsMiddleware;
use Core\Middleware\CsrfMiddleware;

$router = $app->router();

// ============================================
// Basic Routes
// ============================================

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// ============================================
// API Routes with CORS middleware
// ============================================

$router->group(['prefix' => 'api', 'middleware' => [CorsMiddleware::class]], function ($router) {
    // Get all users
    $router->get('/users', [HomeController::class, 'users']);

    // Get single user by ID
    $router->get('/users/{id}', [HomeController::class, 'showUser']);

    // Create new user
    $router->post('/users', [HomeController::class, 'createUser']);

    // Update user
    $router->put('/users/{id}', [HomeController::class, 'updateUser']);

    // Delete user
    $router->delete('/users/{id}', [HomeController::class, 'deleteUser']);

    // General API info
    $router->get('/', [HomeController::class, 'api']);
});

// ============================================
// Example Routes with Closures
// ============================================

// Simple closure route
$router->get('/hello/{name}', function ($request, $name) {
    return json([
        'message' => "Hello, {$name}!",
        'timestamp' => date('Y-m-d H:i:s')
    ]);
});

// Example: Protected route with Auth middleware
$router->get('/dashboard', function ($request) {
    return view('home', [
        'title' => 'Dashboard',
        'message' => 'Welcome to your protected dashboard!'
    ]);
})->middleware([AuthMiddleware::class]);

// ============================================
// Form Example Routes with CSRF protection
// ============================================

$router->match(['GET', 'POST'], '/contact', function ($request) {
    if ($request->method() === 'POST') {
        return json([
            'success' => true,
            'message' => 'Contact form submitted',
            'data' => $request->all()
        ]);
    }

    return view('home', [
        'title' => 'Contact Us',
        'message' => 'Send us a message'
    ]);
});

// Example: POST route with CSRF protection
$router->post('/submit-form', function ($request) {
    return json([
        'success' => true,
        'message' => 'Form submitted securely with CSRF protection'
    ]);
})->middleware([CsrfMiddleware::class]);
