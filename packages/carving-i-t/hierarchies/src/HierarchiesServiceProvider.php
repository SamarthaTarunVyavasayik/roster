<?php
   
namespace CarvingIT\Hierarchies;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class HierarchiesServiceProvider extends ServiceProvider{
    public function boot(){

        $this->publishes( [ __DIR__.'/config/hierarchies.php' => config_path('hierarchies.php')], 'hierarchies-config');

        $this->publishes([ __DIR__.'/public' => public_path('vendor/hierarchies')], 'hierarchies-assets');

        $this->publishes([ __DIR__.'/views' => resource_path('views/vendor/hierarchies')], 'hierarchies-views');

        $this->publishes([ __DIR__.'/database/migrations' => database_path('migrations')], 'hierarchies-migrations');

        $base_path = Config::get('hierarchies.base_path');
        $middleware = Config::get('hierarchies.middleware');

        Route::group(['prefix'=> $base_path, 'middleware'=> $middleware], function () {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });

        $this->loadViewsFrom(__DIR__.'/views', 'hierarchies');

    }
    public function register(){
    }
}
?>
