<?php

namespace App\Providers;

use App\Announcement;
use App\Classification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //share classificationList to all pages
        //notice: if there are too much classifications, then there will be some problems!
        view()->composer('*',function($view){
            $view->with('classificationList',Classification::all());
            $view->with('announcements',Announcement::where('visible', 1)->orderBy('updated_at', 'desc')->take(5)->get());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
