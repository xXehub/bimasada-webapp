<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // IMPORTANT: Skip all gate checks for cached permissions
        // This drastically reduces database queries for remote DB (Supabase)
        Gate::before(function ($user, $ability) {
            $cacheKey = "user_roles_perms_{$user->id}";
            $cached = Cache::get($cacheKey);
            
            if ($cached) {
                // Admin has all permissions
                if (in_array('Admin', $cached['roles'] ?? [])) {
                    return true;
                }
                
                // Check if user has the permission in cache
                if (in_array($ability, $cached['permissions'] ?? [])) {
                    return true;
                }
                
                // Check role-based permissions (common pattern: role-name => permission-name)
                // For example: 'Sales' role should have 'view-invoices', 'create-invoices', etc.
                $rolePermissionMap = [
                    'Marketing Manager' => [
                        'view-invoices', 'view-pks', 'view-kuitansis', 'view-archive',
                        'review-invoices', 'review-pks', 'review-kuitansis',
                        'approve-invoices', 'approve-pks',
                    ],
                    'Sales' => [
                        'view-invoices', 'create-invoices', 'edit-invoices',
                        'view-pks', 'create-pks', 'edit-pks',
                        'view-kuitansis', 'create-kuitansis', 'edit-kuitansis',
                        'view-archive',
                    ],
                ];
                
                foreach ($cached['roles'] ?? [] as $role) {
                    if (isset($rolePermissionMap[$role]) && in_array($ability, $rolePermissionMap[$role])) {
                        return true;
                    }
                }
            }
            
            return null; // Let other gates/policies handle it
        });
        
        // Cache user permissions on login
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            $cacheKey = "user_roles_perms_{$user->id}";
            
            // Pre-load and cache permissions
            $user->load(['roles.permissions', 'permissions']);
            
            Cache::put($cacheKey, [
                'roles' => $user->roles->pluck('name')->toArray(),
                'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                'loaded' => true,
            ], 7200); // 2 hours cache
        });
        
        // Clear cache on logout
        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                Cache::forget("user_roles_perms_{$event->user->id}");
            }
        });
    }
}
