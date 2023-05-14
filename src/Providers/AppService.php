<?php

namespace TheBachtiarz\UserResource\Providers;

class AppService
{
    //

    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Available command modules
     *
     * @var array
     */
    public const COMMANDS = [];

    // ? Public Methods
    /**
     * Register config
     *
     * @return void
     */
    public function registerConfig(): void
    {
        $this->setConfigs();
    }

    // ? Private Methods
    /**
     * Set configs
     *
     * @return void
     */
    private function setConfigs(): void
    {
        $container = \Illuminate\Container\Container::getInstance();

        /** @var DataService $_dataService */
        $_dataService = $container->make(DataService::class);

        foreach ($_dataService->registerConfig() as $key => $register)
            config($register);
    }

    // ? Setter Modules
}
