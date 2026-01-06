<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CachePermissions
{
    /**
     * Cache user roles and permissions to reduce database queries.
     * This is especially important for remote databases like Supabase.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user) {
            $cacheKey = "user_roles_perms_{$user->id}";
            
            // Check if already cached
            if (!Cache::has($cacheKey)) {
                // Force load roles and permissions once (single optimized query)
                $user->load(['roles.permissions', 'permissions']);
                
                // Cache the data for 2 hours
                Cache::put($cacheKey, [
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                    'loaded' => true,
                ], 7200);
            }
        }
        
        return $next($request);
    }
}
