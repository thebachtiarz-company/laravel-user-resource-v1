<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Curl\Path;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Interfaces\Config\CurlRestInterface;
use TheBachtiarz\UserResource\Libraries\Curl\AbstractCurl;

class AccountUpdate extends AbstractCurl implements CurlInterface
{
    /**
     * Account detail
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setPath(CurlRestInterface::SUB_ACCOUNT_UPDATE)->setBody($data)->post();
    }
}
