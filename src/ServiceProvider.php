<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheBachtiarz\UserResource\Interfaces\Config\UserResourceConfigInterface;
use TheBachtiarz\UserResource\Providers\AppService;

use function app;
use function assert;
use function config_path;
use function database_path;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $appService = app(AppService::class);
        assert($appService instanceof AppService);

        $appService->registerConfig();

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(AppService::COMMANDS);
    }

    /**
     * Boot
     */
    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            return;
        }

        $configName  = UserResourceConfigInterface::CONFIG_NAME;
        $publishName = 'thebachtiarz-userresource';

        $this->publishes([__DIR__ . "/../config/$configName.php" => config_path("$configName.php")], "$publishName-config");
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$publishName-migrations");
    }
}
