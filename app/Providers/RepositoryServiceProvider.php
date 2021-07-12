<?php

namespace App\Providers;

use App\Contracts\UserContract;
use App\Contracts\InterestCategoryContract;
use App\Contracts\SubInterestCategoryContract;
use App\Contracts\ColorPaletteContract;
use App\Contracts\CommonContract;
use App\Contracts\AddressBookContract;
use App\Contracts\GroupContract;
use App\Contracts\FollowerFollowingContract;
use App\Contracts\PollContract;
use App\Contracts\ContactUsContract;
use App\Contracts\PollVoteContract;
use App\Contracts\PollCommentContract;
use App\Contracts\ActivityContract;
use App\Contracts\NotificationContract;


use App\Repositories\UserRepository;
use App\Repositories\InterestCategoryRepository;
use App\Repositories\SubInterestCategoryRepository;
use App\Repositories\CommonRepository;
use App\Repositories\ColorPaletteRepository;
use App\Repositories\AddressBookRepository;
use App\Repositories\GroupRepository;
use App\Repositories\FollowerFollowingRepository;
use App\Repositories\PollRepository;
use App\Repositories\ConatcUsRepository;
use App\Repositories\PollVoteRepository;
use App\Repositories\PollCommentRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\NotificationRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserContract::class, UserRepository::class);
        $this->app->bind(InterestCategoryContract::class, InterestCategoryRepository::class);
        $this->app->bind(SubInterestCategoryContract::class, SubInterestCategoryRepository::class);
        $this->app->bind(CommonContract::class, CommonRepository::class);
        $this->app->bind(ColorPaletteContract::class, ColorPaletteRepository::class);
        $this->app->bind(AddressBookContract::class, AddressBookRepository::class);
        $this->app->bind(GroupContract::class, GroupRepository::class);
        $this->app->bind(FollowerFollowingContract::class, FollowerFollowingRepository::class);
        $this->app->bind(PollContract::class, PollRepository::class);
        $this->app->bind(ContactUsContract::class, ConatcUsRepository::class);
        $this->app->bind(PollVoteContract::class, PollVoteRepository::class);
        $this->app->bind(PollCommentContract::class, PollCommentRepository::class);
        $this->app->bind(ActivityContract::class, ActivityRepository::class);
        $this->app->bind(NotificationContract::class, NotificationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
