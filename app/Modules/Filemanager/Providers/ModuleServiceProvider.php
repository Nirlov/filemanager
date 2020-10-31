<?php

namespace App\Modules\Filemanager\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('filemanager', 'Resources/Lang', 'app'), 'filemanager');
        $this->loadViewsFrom(module_path('filemanager', 'Resources/Views', 'app'), 'filemanager');
        $this->loadMigrationsFrom(module_path('filemanager', 'Database/Migrations', 'app'), 'filemanager');
        $this->loadConfigsFrom(module_path('filemanager', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('filemanager', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
