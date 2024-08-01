<?php

namespace App\Providers;

        use App\Repositories\Sql\JobApplicationRepository;
        use App\Repositories\Contract\JobApplicationRepositoryInterface;

        use App\Repositories\Sql\ValueRepository;
        use App\Repositories\Contract\ValueRepositoryInterface;

        use App\Repositories\Sql\VallageRepository;
        use App\Repositories\Contract\VallageRepositoryInterface;
        
        use App\Repositories\Sql\SectorRepository;
        use App\Repositories\Contract\SectorRepositoryInterface;

        use App\Repositories\Sql\JobVacancyRepository;
        use App\Repositories\Contract\JobVacancyRepositoryInterface;

        use App\Repositories\Sql\CategoryRepository;
        use App\Repositories\Contract\CategoryRepositoryInterface;

        use App\Repositories\Sql\SolutionRepository;
        use App\Repositories\Contract\SolutionRepositoryInterface;

        use App\Repositories\Sql\BrandRepository;
        use App\Repositories\Contract\BrandRepositoryInterface;

        use App\Repositories\Sql\ServiceRepository;
        use App\Repositories\Contract\ServiceRepositoryInterface;

        use App\Repositories\Sql\TalkRepository;
        use App\Repositories\Contract\TalkRepositoryInterface;

        use App\Repositories\Sql\ScrapRepository;
        use App\Repositories\Contract\ScrapRepositoryInterface;

        use App\Repositories\Sql\AboutRepository;
        use App\Repositories\Contract\AboutRepositoryInterface;

        use App\Repositories\Sql\MailListRepository;
        use App\Repositories\Contract\MailListRepositoryInterface;

        use App\Repositories\Sql\SettingRepository;
        use App\Repositories\Contract\SettingRepositoryInterface;

        use App\Repositories\Sql\VideoRepository;
        use App\Repositories\Contract\VideoRepositoryInterface;

        use App\Repositories\Sql\ArticleRepository;
        use App\Repositories\Contract\ArticleRepositoryInterface;

        use App\Repositories\Sql\BookRepository;
        use App\Repositories\Contract\BookRepositoryInterface;

        use App\Repositories\Sql\ReviewRepository;
        use App\Repositories\Contract\ReviewRepositoryInterface;
        
        use App\Repositories\Sql\UserRepository;
        use App\Repositories\Contract\UserRepositoryInterface;

        use App\Repositories\Sql\ContactRepository;
        use App\Repositories\Contract\ContactRepositoryInterface;
// interface


use App\Repositories\Contract\BaseRepositoryInterface;
// repository

use App\Repositories\Sql\BaseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{

    public function register(){

        $this->app->bind(JobApplicationRepositoryInterface::class, JobApplicationRepository::class);
        $this->app->bind(VallageRepositoryInterface::class, VallageRepository::class);

        $this->app->bind(ValueRepositoryInterface::class, ValueRepository::class);

        $this->app->bind(SectorRepositoryInterface::class, SectorRepository::class);

        $this->app->bind(JobVacancyRepositoryInterface::class, JobVacancyRepository::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->bind(SolutionRepositoryInterface::class, SolutionRepository::class);

        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);

        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);

        $this->app->bind(TalkRepositoryInterface::class, TalkRepository::class);

        $this->app->bind(ScrapRepositoryInterface::class, ScrapRepository::class);

        $this->app->bind(AboutRepositoryInterface::class, AboutRepository::class);

        $this->app->bind(MailListRepositoryInterface::class, MailListRepository::class);

        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);

        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);

        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);

        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);

        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);

    }

    public function boot()
    {
        //
    }

}
