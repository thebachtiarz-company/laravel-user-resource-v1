<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries;

use TheBachtiarz\Base\App\Libraries\Curl\AbstractCurl;

use function sprintf;
use function tbuserresconfig;

abstract class AbstractAccountLibrary extends AbstractCurl
{
    protected function urlDomainResolver(): string
    {
        $baseUrl = tbuserresconfig(keyName: 'is_production_mode', useOrigin: false)
            ? 'api_url_production'
            : 'api_url_sandbox';

        $this->url = sprintf(
            '%s/%s/%s',
            tbuserresconfig(keyName: $baseUrl, useOrigin: false),
            'rest/v1',
            $this->getSubUrl(),
        );

        return $this->url;
    }

    /**
     * {@inheritDoc}
     */
    protected function bodyDataResolver(): array
    {
        return $this->body;
    }
}
