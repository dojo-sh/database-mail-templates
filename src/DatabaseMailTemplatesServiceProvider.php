<?php

namespace DojoSh\DatabaseMailTemplates;

use DojoSh\DatabaseMailTemplates\Commands\MakeTemplateMailableCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class DatabaseMailTemplatesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/database-mail-templates.php', 'database-mail-templates');

        $this->publishes([
            __DIR__ . '/../config/database-mail-templates.php' => config_path('database-mail-templates.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../resources/views/components' => resource_path('views/vendor/database-mail-templates/components'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'database-mail-templates');


        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->commands([MakeTemplateMailableCommand::class]);
    }

    public function register()
    {
    }
}
