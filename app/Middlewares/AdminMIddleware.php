<?php

namespace App\Middlewares;

use Core\Middleware\MiddlewareInterface;


class AdminMIddleware implements MiddlewareInterface
{
    public function handle($request, \Closure $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            // TODO: add alert message 
            header('Location: /login');
            exit;
        }
        return $next($request);
    }
}