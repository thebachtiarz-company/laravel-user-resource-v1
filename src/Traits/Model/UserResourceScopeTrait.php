<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Traits\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;

/**
 * User Resource Scope Trait
 */
trait UserResourceScopeTrait
{
    /**
     * Get by account code
     */
    public function scopeGetByAccountCode(Builder $builder, string $accountCode): Builder
    {
        $attribute = UserResourceInterface::ATTRIBUTE_ACCOUNTCODE;

        return $builder->where(DB::raw("BINARY `$attribute`"), $accountCode);
    }

    /**
     * Get by biodata code
     */
    public function scopeGetByBiodataCode(Builder $builder, string $biodataCode): Builder
    {
        $attribute = UserResourceInterface::ATTRIBUTE_BIODATACODE;

        return $builder->where(DB::raw("BINARY `$attribute`"), $biodataCode);
    }
}
