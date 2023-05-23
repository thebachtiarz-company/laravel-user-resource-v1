<?php

declare(strict_types=1);

use TheBachtiarz\UserResource\Interfaces\Config\UserResourceConfigInterface;

if (! function_exists('tbuserresconfig')) {
    /**
     * TheBachtiarz user resource config
     *
     * @param string|null $keyName   Config key name | null will return all
     * @param bool|null   $useOrigin Use original value from config
     */
    function tbuserresconfig(string|null $keyName = null, bool|null $useOrigin = true): mixed
    {
        $configName = UserResourceConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}
