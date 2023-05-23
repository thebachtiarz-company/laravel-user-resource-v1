<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Providers;

use TheBachtiarz\Base\BaseConfigInterface;
use TheBachtiarz\UserResource\Interfaces\Config\UserResourceConfigInterface;

use function array_merge;
use function tbbaseconfig;

class DataService
{
    /**
     * List of config who need to registered into current project
     *
     * @return array
     */
    public function registerConfig(): array
    {
        $registerConfig = [];

        $configRegistered = tbbaseconfig(BaseConfigInterface::CONFIG_REGISTERED);
        $registerConfig[] = [
            BaseConfigInterface::CONFIG_NAME . '.' . BaseConfigInterface::CONFIG_REGISTERED => array_merge(
                $configRegistered,
                [UserResourceConfigInterface::CONFIG_NAME],
            ),
        ];

        return $registerConfig;
    }
}
