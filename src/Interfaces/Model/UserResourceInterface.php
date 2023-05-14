<?php

namespace TheBachtiarz\UserResource\Interfaces\Model;

use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;

interface UserResourceInterface extends AbstractModelInterface
{
    //

    public const TABLE_NAME = 'user_resources';

    public const ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_ACCOUNTCODE,
        self::ATTRIBUTE_BIODATACODE,
        self::ATTRIBUTE_DATACACHE
    ];

    public const ATTRIBUTE_ACCOUNTCODE = 'account_code';
    public const ATTRIBUTE_BIODATACODE = 'biodata_code';
    public const ATTRIBUTE_DATACACHE = 'data_cache';

    // ? Getter Modules
    /**
     * Get account code
     *
     * @return string|null
     */
    public function getAccountCode(): ?string;

    /**
     * Get biodata code
     *
     * @return string|null
     */
    public function getBiodataCode(): ?string;

    /**
     * Get data cache
     *
     * @return string|null
     */
    public function getDataCache(): ?string;

    // ? Setter Modules
    /**
     * Set account code
     *
     * @param string $accountCode
     * @return self
     */
    public function setAccountCode(string $accountCode): self;

    /**
     * Set biodata code
     *
     * @param string $biodataCode
     * @return self
     */
    public function setBiodataCode(string $biodataCode): self;

    /**
     * Set data cache
     *
     * @param string $dataCache
     * @return self
     */
    public function setDataCache(string $dataCache): self;
}
