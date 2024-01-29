<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
          // Access Role staff
          Gate::define('staff', function(User $user){
            return $user->role === 'staff';
        });

             // Access Role manager
             Gate::define('manager', function(User $user){
                return $user->role === 'manager';
            });

    

    }
}
