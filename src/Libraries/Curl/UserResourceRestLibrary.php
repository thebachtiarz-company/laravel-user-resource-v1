<?php

namespace TheBachtiarz\UserResource\Libraries\Curl;

use TheBachtiarz\Base\App\Libraries\Curl\CurlLibrary;
use TheBachtiarz\UserResource\Interfaces\Config\CurlRestInterface;

class UserResourceRestLibrary extends CurlLibrary
{
    //

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classEntity = [
            CurlRestInterface::ACCOUNT_DETAIL_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\AccountDetail::class,
            CurlRestInterface::ACCOUNT_BIODATA_LATEST_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\AccountBiodataLatest::class,
            CurlRestInterface::ACCOUNT_CREATE_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\AccountCreate::class,
            CurlRestInterface::ACCOUNT_UPDATE_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\AccountUpdate::class,
            CurlRestInterface::BIODATA_DETAIL_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataDetail::class,
            CurlRestInterface::BIODATA_ATTRIBUTE_HISTORY_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataAttributeHistory::class,
            CurlRestInterface::BIODATA_CREATE_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataCreate::class,
            CurlRestInterface::BIODATA_UPDATE_PATH_NAME => \TheBachtiarz\UserResource\Libraries\Curl\Path\BiodataUpdate::class,
        ];
    }
}
