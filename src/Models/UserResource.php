<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Models;

use Illuminate\Support\Facades\Crypt;
use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;
use TheBachtiarz\UserResource\Traits\Models\UserResourceMapTrait;
use TheBachtiarz\UserResource\Traits\Models\UserResourceScopeTrait;
use Throwable;

class UserResource extends AbstractModel implements UserResourceInterface
{
    use UserResourceScopeTrait;
    use UserResourceMapTrait;

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);

        parent::__construct($attributes);
    }

    // ? Getter Modules

    /**
     * Get account code
     */
    public function getAccountCode(): string|null
    {
        return $this->__get(self::ATTRIBUTE_ACCOUNTCODE);
    }

    /**
     * Get biodata code
     */
    public function getBiodataCode(): string|null
    {
        return $this->__get(self::ATTRIBUTE_BIODATACODE);
    }

    /**
     * Get data cache
     */
    public function getDataCache(): string|null
    {
        try {
            return Crypt::decryptString($this->__get(self::ATTRIBUTE_DATACACHE));
        } catch (Throwable) {
            return null;
        }
    }

    // ? Setter Modules

    /**
     * Set account code
     */
    public function setAccountCode(string $accountCode): self
    {
        $this->__set(self::ATTRIBUTE_ACCOUNTCODE, $accountCode);

        return $this;
    }

    /**
     * Set biodata code
     */
    public function setBiodataCode(string $biodataCode): self
    {
        $this->__set(self::ATTRIBUTE_BIODATACODE, $biodataCode);

        return $this;
    }

    /**
     * Set data cache
     */
    public function setDataCache(string $dataCache): self
    {
        $this->__set(self::ATTRIBUTE_DATACACHE, Crypt::encryptString($dataCache));

        return $this;
    }
}
