<?php

namespace TheBachtiarz\UserResource\Interfaces\Config;

interface CurlRestInterface
{
    //

    public const ACCOUNT_DETAIL_PATH_NAME = 'account-detail';
    public const ACCOUNT_BIODATA_LATEST_PATH_NAME = 'account-biodata-latest';
    public const ACCOUNT_CREATE_PATH_NAME = 'account-create';
    public const ACCOUNT_UPDATE_PATH_NAME = 'account-update';
    public const BIODATA_DETAIL_PATH_NAME = 'biodata-detail';
    public const BIODATA_ATTRIBUTE_HISTORY_PATH_NAME = 'biodata-attribute-history';
    public const BIODATA_CREATE_PATH_NAME = 'biodata-create';
    public const BIODATA_UPDATE_PATH_NAME = 'biodata-update';

    public const SUB_ACCOUNT_DETAIL = 'account/detail';
    public const SUB_ACCOUNT_BIODATA_LATEST = 'account/biodata-latest';
    public const SUB_ACCOUNT_CREATE = 'account/create';
    public const SUB_ACCOUNT_UPDATE = 'account/update';
    public const SUB_BIODATA_DETAIL = 'biodata/detail';
    public const SUB_BIODATA_ATTRIBUTE_HISTORY = 'biodata/attribute-history';
    public const SUB_BIODATA_CREATE = 'biodata/create';
    public const SUB_BIODATA_UPDATE = 'biodata/update';
}
