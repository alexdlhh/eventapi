<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\AuthController;
use App\Labels\Lang;
use App\Http\Helpers\RestrictiveHelper;
use App\Http\Helpers\CommonHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make(AuthController::class);
        $this->app->make(Lang::class);
        $this->app->make(RestrictiveHelper::class);
        $this->app->make(CommonHelper::class);
    }
}
