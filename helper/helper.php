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
        try {
            $configName = UserResourceConfigInterface::CONFIG_NAME;

            if ($useOrigin) {
                return iconv_strlen($keyName)
                    ? config("{$configName}.{$keyName}")
                    : config("{$configName}");
            } else {
                return tbconfigvalue("{$configName}.{$keyName}");
            }
        } catch (\Throwable $th) {
        }

        return null;
    }
}
