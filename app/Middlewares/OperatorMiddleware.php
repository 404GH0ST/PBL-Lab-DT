<?php

namespace App\Middlewares;

use Core\Middleware\MiddlewareInterface;


class OperatorMiddleware implements MiddlewareInterface
{
    public function handle($request, \Closure $next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['user']['role'] !== 'operator') {
            header('Location: /operator/dashboard');
            exit;
        }
        return $next($request);
    }
}