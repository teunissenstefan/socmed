<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Poowf\Otter\Otter;
use Illuminate\Support\Facades\Gate;
use Poowf\Otter\OtterApplicationServiceProvider;

class OtterServiceProvider extends OtterApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Otter::night();
    }

    /**
     * Register the Otter gate.
     *
     * This gate determines who can access Otter in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewOtter', function ($user) {
            if(Auth::check() && Auth::user()->admin===1){
                return true;
            }
            return in_array($user->email, [
                //
            ]);
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