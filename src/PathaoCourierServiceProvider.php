<?php

namespace Codeboxr\PathaoCourier;

use Illuminate\Support\ServiceProvider;
use Codeboxr\PathaoCourier\Apis\AreaApi;
use Codeboxr\PathaoCourier\Manage\Manage;
use Codeboxr\PathaoCourier\Apis\StoreApi;
use Codeboxr\PathaoCourier\Apis\OrderApi;

class PathaoCourierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../config/pathao.php" => config_path("pathao.php")
        ]);
    }

    /**
     * Register application services
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/pathao.php", "pathao");

        $this->app->bind("pathaocourier", function () {
            return new Manage(new AreaApi(), new StoreApi(), new OrderApi());
        });
    }

}
