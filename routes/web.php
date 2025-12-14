<?php
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\PublicationController;
use App\Controllers\HomeController;
use App\Controllers\ContactController;
use Core\Middleware\AuthMiddleware;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\Admin\MemberController;
use App\Controllers\Admin\VisiMisiController;
use App\Middlewares\AdminMiddleware;
use App\Controllers\Admin\NewsController;
use App\Controllers\Admin\ApprovalController;
use App\Controllers\Admin\InfoLabController;
use App\Controllers\Admin\UserProfileController;
use App\Controllers\Admin\FasilitasController;
use App\Controllers\Admin\FokusRisetController;
use App\Controllers\Admin\ActivityController;
use App\Controllers\Admin\CourseController;

$router = $app->router();


// ============================================
// Basic Routes
// ============================================

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'aboutPage']);
$router->get('/facility', [HomeController::class, 'FacilityPage']);
$router->get('/gallery', [HomeController::class, 'galleryPage']);
$router->get('/publications', [HomeController::class, 'publicationPage']);
$router->get('/news', [HomeController::class, 'NewsPage']);
$router->get('/news/{slug}', [HomeController::class, 'newsDetail']);
$router->get('/login', [HomeController::class, 'loginPage']);
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact/send', [ContactController::class, 'send']);
$router->get('/member/{id}', [App\Controllers\MemberController::class, 'show']);

// ============================================
// Auth Routes
// ============================================
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/logout', [AuthController::class, 'logout']);

// Forgot Password Routes
$router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'sendResetLink']);
$router->get('/reset-password/{token}', [AuthController::class, 'resetPassword']);
$router->post('/reset-password', [AuthController::class, 'updatePassword']);

// ============================================
// Admin Routes
// ============================================
$router->get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(AuthMiddleware::class);

// User Profile Routes
$router->get('/admin/my-profile', [UserProfileController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->post('/admin/my-profile/update', [UserProfileController::class, 'update'])->middleware([AuthMiddleware::class]);

// Members Routes
$app->router()->get('/admin/members', [MemberController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/members', [MemberController::class, 'store'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
$app->router()->post('/admin/members/{id}/update', [MemberController::class, 'update'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
$app->router()->post('/admin/members/{id}/delete', [MemberController::class, 'destroy'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// Vision & Mission Routes
$app->router()->get('/admin/visimisi', [VisiMisiController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/visimisi', [VisiMisiController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/visimisi/{id}/update', [VisiMisiController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/visimisi/{id}/delete', [VisiMisiController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Approval Routes
$app->router()->get('/admin/approvals', [ApprovalController::class, 'index'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
$app->router()->post('/admin/approvals/{type}/{id}/approve', [ApprovalController::class, 'approve'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
$app->router()->post('/admin/approvals/{type}/{id}/reject', [ApprovalController::class, 'reject'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

// Lab Info Routes
$app->router()->get('/admin/info-lab', [InfoLabController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/info-lab/update', [InfoLabController::class, 'update'])->middleware([AuthMiddleware::class]);

// Gallery Routes
$app->router()->get('/admin/gallery', [GalleryController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/gallery', [GalleryController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/gallery/{id}/update', [GalleryController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/gallery/{id}/delete', [GalleryController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Publication Routes
$app->router()->get('/admin/publications', [PublicationController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/publications', [PublicationController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/publications/{id}/update', [PublicationController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/publications/{id}/delete', [PublicationController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// News Routes
$app->router()->get('/admin/news', [NewsController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/news', [NewsController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/news/{id}/update', [NewsController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/news/{id}/delete', [NewsController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Fasilitas Routes
$app->router()->get('/admin/fasilitas', [FasilitasController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fasilitas', [FasilitasController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fasilitas/{id}/update', [FasilitasController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fasilitas/{id}/delete', [FasilitasController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Fokus Riset Routes
$app->router()->get('/admin/fokus', [FokusRisetController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fokus', [FokusRisetController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fokus/{id}/update', [FokusRisetController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/fokus/{id}/delete', [FokusRisetController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Activity Routes
$app->router()->get('/admin/activities', [ActivityController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/activities', [ActivityController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/activities/{id}/update', [ActivityController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/activities/{id}/delete', [ActivityController::class, 'destroy'])->middleware([AuthMiddleware::class]);

// Course Routes
$app->router()->get('/admin/courses', [CourseController::class, 'index'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/courses', [CourseController::class, 'store'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/courses/{id}/update', [CourseController::class, 'update'])->middleware([AuthMiddleware::class]);
$app->router()->post('/admin/courses/{id}/delete', [CourseController::class, 'destroy'])->middleware([AuthMiddleware::class]);