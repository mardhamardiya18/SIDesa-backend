<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\DashboardRepositoryInterface;
use App\Interfaces\DevelopmentApplicantRepositoryInterface;
use App\Interfaces\DevelopmentRepositoryInterface;
use App\Interfaces\EventParticipantRepositoryInterface;
use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Interfaces\ProfileRepositoryInterface;
use App\Interfaces\SocialAssistanceRecipientRepositoryInterface;
use App\Interfaces\SocialAssistanceRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\DashboardRepository;
use App\Repositories\DevelopmentApplicantRepository;
use App\Repositories\DevelopmentRepository;
use App\Repositories\EventParticipantRepository;
use App\Repositories\EventRepository;
use App\Repositories\FamilyMemberRepository;
use App\Repositories\HeadOfFamilyRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\SocialAssistanceRecipientRepository;
use App\Repositories\SocialAssistanceRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(HeadOfFamilyRepositoryInterface::class, HeadOfFamilyRepository::class);

        $this->app->bind(
            FamilyMemberRepositoryInterface::class,
            FamilyMemberRepository::class
        );

        $this->app->bind(
            SocialAssistanceRepositoryInterface::class,
            SocialAssistanceRepository::class
        );

        $this->app->bind(
            SocialAssistanceRecipientRepositoryInterface::class,
            SocialAssistanceRecipientRepository::class
        );

        $this->app->bind(
            EventRepositoryInterface::class,
            EventRepository::class
        );

        $this->app->bind(
            EventParticipantRepositoryInterface::class,
            EventParticipantRepository::class
        );

        $this->app->bind(
            DevelopmentRepositoryInterface::class,
            DevelopmentRepository::class
        );

        $this->app->bind(
            DevelopmentApplicantRepositoryInterface::class,
            DevelopmentApplicantRepository::class
        );

        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );

        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );

        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
