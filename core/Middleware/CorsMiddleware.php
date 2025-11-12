<?php

namespace Core\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Closure;

/**
 * CORS Middleware
 * Handles Cross-Origin Resource Sharing headers
 */
class CorsMiddleware implements MiddlewareInterface
{
    protected array $allowedOrigins;
    protected array $allowedMethods;
    protected array $allowedHeaders;

    public function __construct(
        array $allowedOrigins = ['*'],
        array $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        array $allowedHeaders = ['Content-Type', 'Authorization', 'X-Requested-With']
    ) {
        $this->allowedOrigins = $allowedOrigins;
        $this->allowedMethods = $allowedMethods;
        $this->allowedHeaders = $allowedHeaders;
    }

    public function handle(Request $request, Closure $next)
    {
        // Handle preflight requests
        if ($request->method() === 'OPTIONS') {
            return $this->handlePreflightRequest();
        }

        /** @var Response $response */
        $response = $next($request);

        // Add CORS headers
        $response->setHeader('Access-Control-Allow-Origin', implode(', ', $this->allowedOrigins));
        $response->setHeader('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods));
        $response->setHeader('Access-Control-Allow-Headers', implode(', ', $this->allowedHeaders));
        $response->setHeader('Access-Control-Max-Age', '86400');

        return $response;
    }

    protected function handlePreflightRequest(): Response
    {
        return new Response('', 200, [
            'Access-Control-Allow-Origin' => implode(', ', $this->allowedOrigins),
            'Access-Control-Allow-Methods' => implode(', ', $this->allowedMethods),
            'Access-Control-Allow-Headers' => implode(', ', $this->allowedHeaders),
            'Access-Control-Max-Age' => '86400',
        ]);
    }
}
