<?php

namespace App\Http\Middleware\Api;

use App\Models\Registration_request;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class Industrial_area_representative_middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        Gate::authorize('view_or_details_or_accept_denied', Registration_request::class);

        Gate::authorize('view_subdomain_users', Registration_request::class);

        return $next($request);
    }
}
