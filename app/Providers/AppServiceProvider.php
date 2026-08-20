<?php

namespace App\Providers;

use App\Repositories\GalleryCategoryRepository;
use App\Repositories\Interfaces\GalleryCategoryRepositoryInterface;
use App\Repositories\GalleryRepository;
use App\Repositories\Interfaces\GalleryRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\TestimonialRepository;
use App\Repositories\Interfaces\TestimonialRepositoryInterface;
use App\Repositories\TeamMemberRepository;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;
use App\Repositories\VideoRepository;
use App\Repositories\Interfaces\VideoRepositoryInterface;
use App\Repositories\InquiryRepository;
use App\Repositories\Interfaces\InquiryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GalleryCategoryRepositoryInterface::class, GalleryCategoryRepository::class);
        $this->app->bind(GalleryRepositoryInterface::class, GalleryRepository::class);
        $this->app->bind(TestimonialRepositoryInterface::class, TestimonialRepository::class);
        $this->app->bind(TeamMemberRepositoryInterface::class, TeamMemberRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
        $this->app->bind(InquiryRepositoryInterface::class, InquiryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
