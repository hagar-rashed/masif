<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\JobVacancy;
use App\Observers\ArticleObserver;
use App\Observers\JobVacancyObserver;
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
        Article::observe(ArticleObserver::class);
        JobVacancy::observe(JobVacancyObserver::class);
    }
}
