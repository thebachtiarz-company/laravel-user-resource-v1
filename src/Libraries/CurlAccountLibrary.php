<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries;

use TheBachtiarz\Base\App\Libraries\Curl\CurlLibrary;
use TheBachtiarz\UserResource\Libraries\Accounts\AccountBiodataLatestDetail;
use TheBachtiarz\UserResource\Libraries\Accounts\AccountDetail;
use TheBachtiarz\UserResource\Libraries\Accounts\AccountUpdate;
use TheBachtiarz\UserResource\Libraries\Accounts\AccountWithBiodataCreate;
use TheBachtiarz\UserResource\Libraries\Biodatas\BiodataAttributeHistory;
use TheBachtiarz\UserResource\Libraries\Biodatas\BiodataCreate;
use TheBachtiarz\UserResource\Libraries\Biodatas\BiodataDetail;
use TheBachtiarz\UserResource\Libraries\Biodatas\BiodataUpdate;

class CurlAccountLibrary extends CurlLibrary
{
    public const ACCOUNT_DETAIL_PATH              = 'account-detail';
    public const ACCOUNT_BIODATA_LATEST_PATH      = 'account-biodata-latest';
    public const ACCOUNT_CREATE_WITH_BIODATA_PATH = 'account-create-with-biodata';
    public const ACCOUNT_UPDATE_PATH              = 'account-update';
    public const BIODATA_DETAIL_PATH              = 'biodata-detail';
    public const BIODATA_ATTRIBUTE_HISTORY_PATH   = 'biodata-attribute-history';
    public const BIODATA_CREATE_PATH              = 'biodata-create';
    public const BIODATA_UPDATE_PATH              = 'biodata-update';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classEntity = [
            self::ACCOUNT_DETAIL_PATH => AccountDetail::class,
            self::ACCOUNT_BIODATA_LATEST_PATH => AccountBiodataLatestDetail::class,
            self::ACCOUNT_CREATE_WITH_BIODATA_PATH => AccountWithBiodataCreate::class,
            self::ACCOUNT_UPDATE_PATH => AccountUpdate::class,
            self::BIODATA_DETAIL_PATH => BiodataDetail::class,
            self::BIODATA_ATTRIBUTE_HISTORY_PATH => BiodataAttributeHistory::class,
            self::BIODATA_CREATE_PATH => BiodataCreate::class,
            self::BIODATA_UPDATE_PATH => BiodataUpdate::class,
        ];
    }
}
