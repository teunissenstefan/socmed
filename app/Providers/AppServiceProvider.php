<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('*', function($view)
        {
            if(Auth::check()){
                $user = Auth::user();
                $user->stillonline();
                $pendingFriendRequestsForMe = count($user->pendingFriendRequestsForMe);
                $countMessagesForMe = count($user->unreadMessages());

                $totalNotifications = $pendingFriendRequestsForMe+$countMessagesForMe;
                $data = [
                    'countFriendRequestsForMe' => $pendingFriendRequestsForMe,
                    'countMessagesForMe' => $countMessagesForMe,
                    'totalNotifications' => $totalNotifications
                ];
                $view->with($data);
            }
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
