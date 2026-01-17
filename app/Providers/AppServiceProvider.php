<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Categories;

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
        view()->composer('*', function ($view) {
            $view->with('dropdownCategories', Categories::where('type', 1)->where('status', 1)->orderBy('title')->get());
        });
    }
}
