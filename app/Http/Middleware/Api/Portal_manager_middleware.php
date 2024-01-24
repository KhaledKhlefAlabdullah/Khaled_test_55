<?php

namespace App\Http\Middleware\Api;

use App\Models\Industrial_area;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class Portal_manager_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Gate::authorize('view_details_create_update', Industrial_area::class);

        return $next($request);
    }
}
