<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Aturan pembatasan halaman
        Gate::define('access-student', function (User $user) {
            return $user->role === 'student';
        });

        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
