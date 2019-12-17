<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Menu;

class AppServiceProvider extends ServiceProvider
{
    protected $moneySign;
    protected $site_name;
    protected $site_logo;
    protected $favicon;
    protected $menu;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('path.public', function() {
        //     return realpath(base_path().'/../public_html');
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->moneySign = Cache::get("mSign") ?: "$";
        $this->site_name = Cache::get("site_name") ?: config('site.header.name');
        $this->site_logo = Cache::get("site_logo") ?: config('site.header.logo');
        $this->favicon = Cache::get("favicon") ?: config('site.header.favicon');
        $this->menu = new Menu();

        View::share([
            'moneySign' => $this->moneySign,
            'site_name' => $this->site_name,
            'site_logo' => $this->site_logo,
            'favicon' => $this->favicon,
            'menu' => $this->menu
        ]);

        // Using class based composers...
        View::composer(
            ['helpers.header', 'home'],
            'App\View\Composers\HeaderComposer'
        );
    }
}
