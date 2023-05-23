<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\CurlLibrary;
use TheBachtiarz\UserResource\Interfaces\Config\CurlRestInterface;
use TheBachtiarz\UserResource\Libraries\Curl\Path\AccountBiodataLatest;
use TheBachtiarz\UserResource\Libraries\Curl\Path\AccountCreate;
use TheBachtiarz\UserResource\Libraries\Curl\Path\AccountDetail;
use TheBachtiarz\UserResource\Libraries\Curl\Path\AccountUpdate;
use TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataAttributeHistory;
use TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataCreate;
use TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataDetail;
use TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataUpdate;

class UserResourceRestLibrary extends CurlLibrary
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classEntity = [
            CurlRestInterface::ACCOUNT_DETAIL_PATH_NAME => AccountDetail::class,
            CurlRestInterface::ACCOUNT_BIODATA_LATEST_PATH_NAME => AccountBiodataLatest::class,
            CurlRestInterface::ACCOUNT_CREATE_PATH_NAME => AccountCreate::class,
            CurlRestInterface::ACCOUNT_UPDATE_PATH_NAME => AccountUpdate::class,
            CurlRestInterface::BIODATA_DETAIL_PATH_NAME => BiodataDetail::class,
            CurlRestInterface::BIODATA_ATTRIBUTE_HISTORY_PATH_NAME => BiodataAttributeHistory::class,
            CurlRestInterface::BIODATA_CREATE_PATH_NAME => BiodataCreate::class,
            CurlRestInterface::BIODATA_UPDATE_PATH_NAME => BiodataUpdate::class,
        ];
    }
}
