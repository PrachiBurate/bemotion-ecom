<?php

namespace App\Providers;
  use App\Models\Setting;
   use App\Models\Blog;
   use App\Models\Category;
use Illuminate\Support\ServiceProvider;

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


public function boot()
{
    view()->share('setting', Setting::first());
    view()->share('footerBlogs', Blog::latest()->take(3)->get());
      view()->composer('*', function ($view) {

        $categories = Category::where('status', 1)
            ->with(['subcategories' => function($q){
                $q->where('status', 1);
            }])
            ->get();

        $view->with('categories', $categories);
    });
}
}
