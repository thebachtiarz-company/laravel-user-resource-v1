<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Accounts;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class AccountBiodataLatestDetail extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Get latest biodata from account
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('account/biodata-latest')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
