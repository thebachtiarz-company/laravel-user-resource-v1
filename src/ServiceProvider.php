<?php

namespace TheBachtiarz\UserResource;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheBachtiarz\UserResource\Interfaces\Config\UserResourceConfigInterface;
use TheBachtiarz\UserResource\Providers\AppService;

class ServiceProvider extends LaravelServiceProvider
{
    //

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $container = \Illuminate\Container\Container::getInstance();

        /** @var AppService $_appService */
        $_appService = $container->make(AppService::class);

        $_appService->registerConfig();

        if ($this->app->runningInConsole()) {
            $this->commands(AppService::COMMANDS);
        }
    }

    /**
     * Boot
     *
     * @return void
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            $_configName = UserResourceConfigInterface::CONFIG_NAME;
            $_publishName = 'thebachtiarz-userresource';

            $this->publishes([__DIR__ . "/../config/$_configName.php" => config_path("$_configName.php")], "$_publishName-config");
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$_publishName-migrations");
        }
    }
}
