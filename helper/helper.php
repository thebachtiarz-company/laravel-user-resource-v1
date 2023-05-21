<?php

use TheBachtiarz\UserResource\Interfaces\Config\UserResourceConfigInterface;

if (!function_exists('tbuserresconfig')) {
    /**
     * TheBachtiarz user resource config
     *
     * @param string|null $keyName Config key name | null will return all
     * @param boolean|null $useOrigin Use original value from config
     * @return mixed
     */
    function tbuserresconfig(?string $keyName = null, ?bool $useOrigin = true): mixed
    {
        $configName = UserResourceConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}
