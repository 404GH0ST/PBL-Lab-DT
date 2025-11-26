<?php

namespace Core\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Closure;

/**
 * Authentication Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            return Response::redirect('/login');
        }

        return $next($request);
    }
}
