<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Accounts;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class AccountWithBiodataCreate extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Create new account with new biodata
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('account/create')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
