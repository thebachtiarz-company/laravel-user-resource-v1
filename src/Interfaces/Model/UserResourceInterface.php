<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Interfaces\Model;

use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;

interface UserResourceInterface extends AbstractModelInterface
{
    public const TABLE_NAME = 'user_resources';

    public const ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_ACCOUNTCODE,
        self::ATTRIBUTE_BIODATACODE,
        self::ATTRIBUTE_DATACACHE,
    ];

    public const ATTRIBUTE_ACCOUNTCODE = 'account_code';
    public const ATTRIBUTE_BIODATACODE = 'biodata_code';
    public const ATTRIBUTE_DATACACHE   = 'data_cache';

    // ? Getter Modules

    /**
     * Get account code
     */
    public function getAccountCode(): string|null;

    /**
     * Get biodata code
     */
    public function getBiodataCode(): string|null;

    /**
     * Get data cache
     */
    public function getDataCache(): string|null;

    // ? Setter Modules

    /**
     * Set account code
     */
    public function setAccountCode(string $accountCode): self;

    /**
     * Set biodata code
     */
    public function setBiodataCode(string $biodataCode): self;

    /**
     * Set data cache
     */
    public function setDataCache(string $dataCache): self;
}
