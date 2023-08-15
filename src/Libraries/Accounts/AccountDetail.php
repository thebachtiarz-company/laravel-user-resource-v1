<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Accounts;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class AccountDetail extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Get detail account
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('account/detail')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
