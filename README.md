# PHP MVC Framework

A straightforward, beginner-friendly PHP MVC framework with clear code flow and robust routing.

## Features

- **Simple & Clear**: Easy to understand code flow - perfect for learning MVC
- **No ORM Abstraction**: Write plain SQL queries - see exactly what's happening
- **Robust Router**: Full-featured routing with parameters, groups, and middleware
- **Request/Response Objects**: Clean HTTP handling
- **MVC Architecture**: Clear separation of concerns
- **Database Layer**: Simple PDO wrapper with prepared statements
- **Essential Middleware**: Auth, CORS, and CSRF protection included
- **Helper Functions**: Convenient global helpers

## Requirements

- PHP 8.0 or higher
- Composer
- Apache (with mod_rewrite) or Nginx
- PostgreSQL (or other PDO-supported database)

## Installation

1. Install dependencies:
```bash
composer dump-autoload
```

2. Configure your database in `config/app.php`:
```php
'database' => [
    'driver' => 'pgsql',      // pgsql for PostgreSQL, mysql for MySQL
    'host' => 'localhost',
    'port' => 5432,           // 5432 for PostgreSQL, 3306 for MySQL
    'database' => 'your_database',
    'username' => 'postgres',
    'password' => 'your_password',
    'charset' => 'utf8',
]
```

3. Point your web server to the `public` directory

## Understanding the Code Flow

### 1. Request Flow
```
User Request → public/index.php → Router → Middleware → Controller → Model → Database
                                              ↓            ↓          ↓
User Response ← View/JSON ← Controller ← Model ← Database
```

### 2. Simple Example - Get All Users

**Route** (`routes/web.php`):
```php
$router->get('/api/users', [HomeController::class, 'users']);
```

**Controller** (`app/Controllers/HomeController.php`):
```php
public function users(Request $request): Response
{
    // Step 1: Load the User model
    $userModel = $this->loadModel(User::class);

    // Step 2: Call model method to get data
    $users = $userModel->getAllUsers();

    // Step 3: Return JSON response
    return $this->json([
        'success' => true,
        'users' => $users
    ]);
}
```

**Model** (`app/Models/User.php`):
```php
public function getAllUsers()
{
    // Plain SQL query - easy to understand!
    $sql = "SELECT * FROM users";
    return $this->db->query($sql);
}
```

**Flow:**
1. User visits `/api/users`
2. Router matches route and checks middleware
3. Middleware allows request to continue
4. Router calls `HomeController::users()`
5. Controller loads `User` model
6. Model executes SQL query `SELECT * FROM users`
7. Database returns results
8. Controller returns JSON response

## Creating a Model

Models are simple classes with clear SQL queries:

```php
<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->db->query($sql);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function createUser($name, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password, created_at)
                VALUES (:name, :email, :password, :created_at)";

        $this->db->execute($sql, [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->db->lastInsertId();
    }
}
```

## Creating a Controller

Controllers handle requests and coordinate between models and views:

```php
<?php

namespace App\Controllers;

use Core\Controller;
use Core\Http\Request;
use Core\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        // Load model
        $userModel = $this->loadModel(User::class);

        // Get data
        $users = $userModel->getAllUsers();

        // Return response
        return $this->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function show(Request $request, $id): Response
    {
        $userModel = $this->loadModel(User::class);
        $user = $userModel->getUserById($id);

        if (!$user) {
            return $this->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return $this->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
```

## Routing

Define routes in `routes/web.php`:

```php
use App\Controllers\HomeController;

$router = $app->router();

// Simple routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// Route with parameter
$router->get('/users/{id}', [HomeController::class, 'showUser']);

// Route groups with prefix and middleware
$router->group(['prefix' => 'api', 'middleware' => [CorsMiddleware::class]], function ($router) {
    $router->get('/users', [HomeController::class, 'users']);
    $router->post('/users', [HomeController::class, 'createUser']);
    $router->put('/users/{id}', [HomeController::class, 'updateUser']);
    $router->delete('/users/{id}', [HomeController::class, 'deleteUser']);
});

// Closure route (receives Request as first parameter)
$router->get('/hello/{name}', function ($request, $name) {
    return json(['message' => "Hello, {$name}!"]);
});

// Multiple HTTP methods
$router->match(['GET', 'POST'], '/contact', [ContactController::class, 'handle']);
```

## Middleware

The framework includes three essential middleware:

### 1. CORS Middleware
Handles Cross-Origin Resource Sharing for APIs:

```php
use Core\Middleware\CorsMiddleware;

// Apply to API routes
$router->group(['prefix' => 'api', 'middleware' => [CorsMiddleware::class]], function ($router) {
    $router->get('/users', [UserController::class, 'index']);
});
```

### 2. Authentication Middleware
Protects routes that require login:

```php
use Core\Middleware\AuthMiddleware;

$router->get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([AuthMiddleware::class]);
```

### 3. CSRF Middleware
Protects forms from Cross-Site Request Forgery:

```php
use Core\Middleware\CsrfMiddleware;

$router->post('/submit-form', [FormController::class, 'submit'])
    ->middleware([CsrfMiddleware::class]);
```

### Creating Custom Middleware

Simply implement the `MiddlewareInterface`:

```php
<?php

namespace App\Middleware;

use Core\Middleware\MiddlewareInterface;
use Core\Http\Request;
use Closure;

class CustomMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        // Do something before the controller

        $response = $next($request);

        // Do something after the controller

        return $response;
    }
}
```

Apply it to routes:
```php
$router->get('/custom', [Controller::class, 'method'])
    ->middleware([CustomMiddleware::class]);
```

## Database Operations

The framework provides two simple methods:

### 1. `query()` - For SELECT queries
```php
$sql = "SELECT * FROM users WHERE status = :status";
$users = $this->db->query($sql, ['status' => 'active']);
// Returns array of results
```

### 2. `execute()` - For INSERT, UPDATE, DELETE
```php
$sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
$this->db->execute($sql, [
    'name' => 'John',
    'email' => 'john@example.com'
]);
// Returns number of affected rows
```

### Get Last Insert ID
```php
$userId = $this->db->lastInsertId();
```

## Creating Views

Views are simple PHP files in `app/Views/`:

```php
<!-- app/Views/users/show.php -->
<?php ob_start(); ?>

<h1>User Profile</h1>
<p>Name: <?= htmlspecialchars($user['name'] ?? 'Unknown') ?></p>
<p>Email: <?= htmlspecialchars($user['email'] ?? 'N/A') ?></p>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout.php'; ?>
```

Return views from controllers:
```php
return $this->view('users.show', ['user' => $user]);
```

## Helper Functions

```php
// Return JSON
return json(['status' => 'success']);

// Return view
return view('home', ['title' => 'Home']);

// Redirect
return redirect('/login');

// Debug (dump and die)
dd($variable);

// Get config
$dbHost = config('database.host');

// Session helpers
session('key', 'value');
$value = session('key');

// CSRF protection
csrf_token();
csrf_field(); // Returns HTML input field
```

## Complete CRUD Example

**routes/web.php:**
```php
$router->group(['prefix' => 'api'], function ($router) {
    $router->get('/users', [UserController::class, 'index']);       // List all
    $router->get('/users/{id}', [UserController::class, 'show']);   // Show one
    $router->post('/users', [UserController::class, 'create']);     // Create
    $router->put('/users/{id}', [UserController::class, 'update']); // Update
    $router->delete('/users/{id}', [UserController::class, 'delete']); // Delete
});
```

## Directory Structure

```
├── app/
│   ├── Controllers/     # Your controllers
│   ├── Models/          # Your models (with plain SQL)
│   └── Views/           # Your views
├── config/
│   └── app.php         # Configuration
├── core/                # Framework core
│   ├── Database/        # Database layer
│   ├── Http/            # Request/Response
│   ├── Middleware/      # Auth, CORS, CSRF middleware
│   ├── Application.php  # Main app
│   ├── Router.php       # Router
│   ├── Route.php        # Route class
│   ├── Controller.php   # Base controller
│   └── Model.php        # Base model
├── public/
│   ├── .htaccess       # Apache rewrite rules
│   └── index.php       # Entry point
├── routes/
│   └── web.php         # Your routes
└── storage/
    └── logs/           # Application logs
```

## Why This Framework is Beginner-Friendly

1. **No Magic**: You write plain SQL - you see exactly what's happening
2. **Clear Flow**: Easy to trace from route → middleware → controller → model → database
3. **No Complex Abstractions**: No ORM, no dependency injection containers, no pipelines
4. **Simple Middleware**: Just a loop checking each middleware - easy to understand
5. **Straightforward**: Just classes, methods, and plain PHP - nothing hidden
6. **Great for Learning**: Understand how MVC works without framework complexity

## License

MIT License

## Contributing

Feel free to submit issues and enhancement requests!
