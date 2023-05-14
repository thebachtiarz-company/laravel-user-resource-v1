<?php

namespace TheBachtiarz\UserResource\Models;

use Illuminate\Support\Facades\Crypt;
use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;
use TheBachtiarz\UserResource\Traits\Model\UserResourceScopeTrait;

class UserResource extends AbstractModel implements UserResourceInterface
{
    use UserResourceScopeTrait;

    /**
     * {@inheritDoc}
     */
    protected $table = self::TABLE_NAME;

    /**
     * {@inheritDoc}
     */
    protected $fillable = self::ATTRIBUTE_FILLABLE;

    // ? Getter Modules
    /**
     * {@inheritDoc}
     */
    public function getAccountCode(): ?string
    {
        return $this->__get(self::ATTRIBUTE_ACCOUNTCODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getBiodataCode(): ?string
    {
        return $this->__get(self::ATTRIBUTE_BIODATACODE);
    }

    /**
     * {@inheritDoc}
     */
    public function getDataCache(): ?string
    {
        try {
            return Crypt::decryptString($this->__get(self::ATTRIBUTE_DATACACHE));
        } catch (\Throwable $th) {
            return null;
        }
    }

    // ? Setter Modules
    /**
     * {@inheritDoc}
     */
    public function setAccountCode(string $accountCode): self
    {
        $this->__set(self::ATTRIBUTE_ACCOUNTCODE, $accountCode);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setBiodataCode(string $biodataCode): self
    {
        $this->__set(self::ATTRIBUTE_BIODATACODE, $biodataCode);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setDataCache(string $dataCache): self
    {
        $this->__set(self::ATTRIBUTE_DATACACHE, Crypt::encryptString($dataCache));

        return $this;
    }
}
