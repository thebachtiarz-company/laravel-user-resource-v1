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
        $this->url = sprintf(
            '%s/%s/%s',
            tbuserresconfig(tbuserresconfig('is_production_mode', false) ? 'api_url_production' : 'api_url_sandbox', false),
            tbuserresconfig('api_url_prefix', false),
            $this->getPath(),
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
