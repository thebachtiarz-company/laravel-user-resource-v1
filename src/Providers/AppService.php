<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Providers;

use function app;
use function assert;
use function config;

class AppService
{
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Available command modules
     */
    public const COMMANDS = [];

    // ? Public Methods

    /**
     * Register config
     */
    public function registerConfig(): void
    {
        $this->setConfigs();
    }

    // ? Private Methods

    /**
     * Set configs
     */
    private function setConfigs(): void
    {
        $dataService = app(DataService::class);
        assert($dataService instanceof DataService);

        foreach ($dataService->registerConfig() as $key => $register) {
            config($register);
        }
    }

    // ? Setter Modules
}
