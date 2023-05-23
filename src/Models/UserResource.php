<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Models;

use Illuminate\Support\Facades\Crypt;
use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;
use TheBachtiarz\UserResource\Traits\Model\UserResourceMapTrait;
use TheBachtiarz\UserResource\Traits\Model\UserResourceScopeTrait;
use Throwable;

class UserResource extends AbstractModel implements UserResourceInterface
{
    use UserResourceScopeTrait;
    use UserResourceMapTrait;

    protected $table = self::TABLE_NAME;

    protected $fillable = self::ATTRIBUTE_FILLABLE;

    public function getAccountCode(): string|null
    {
        return $this->__get(self::ATTRIBUTE_ACCOUNTCODE);
    }

    public function getBiodataCode(): string|null
    {
        return $this->__get(self::ATTRIBUTE_BIODATACODE);
    }

    public function getDataCache(): string|null
    {
        try {
            return Crypt::decryptString($this->__get(self::ATTRIBUTE_DATACACHE));
        } catch (Throwable) {
            return null;
        }
    }

    public function setAccountCode(string $accountCode): self
    {
        $this->__set(self::ATTRIBUTE_ACCOUNTCODE, $accountCode);

        return $this;
    }

    public function setBiodataCode(string $biodataCode): self
    {
        $this->__set(self::ATTRIBUTE_BIODATACODE, $biodataCode);

        return $this;
    }

    public function setDataCache(string $dataCache): self
    {
        $this->__set(self::ATTRIBUTE_DATACACHE, Crypt::encryptString($dataCache));

        return $this;
    }
}
