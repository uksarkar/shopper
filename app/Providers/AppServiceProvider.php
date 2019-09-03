<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    protected $moneySing;

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
        $this->moneySing = Cache::has('monySing') ? Cache::get('monySing'):"$";
        
        View::share('moneySing', $this->moneySing);

        // Using class based composers...
        View::composer(
            ['helpers.header','home'], 'App\View\Composers\HeaderComposer'
        );
    }
}
