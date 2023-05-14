<?php

namespace TheBachtiarz\UserResource\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\AbstractCurl as BaseAbstractCurl;

abstract class AbstractCurl extends BaseAbstractCurl
{
    //

    /**
     * {@inheritDoc}
     */
    protected function urlDomainResolver(): string
    {
        $this->url = sprintf(
            '%s/%s/%s',
            tbuserresconfig(tbuserresconfig('is_production_mode', false) ? 'api_url_production' : 'api_url_sandbox', false),
            tbuserresconfig('api_url_prefix', false),
            $this->getPath()
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
