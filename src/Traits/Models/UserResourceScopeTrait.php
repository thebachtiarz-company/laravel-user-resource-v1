<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Traits\Models;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;

/**
 * User Resource Scope Trait
 */
trait UserResourceScopeTrait
{
    /**
     * Get by account code
     */
    public function scopeGetByAccountCode(EloquentBuilder|QueryBuilder $builder, string $accountCode): BuilderContract
    {
        $attribute = UserResourceInterface::ATTRIBUTE_ACCOUNTCODE;

        return $builder->where(DB::raw("BINARY `$attribute`"), $accountCode);
    }

    /**
     * Get by biodata code
     */
    public function scopeGetByBiodataCode(EloquentBuilder|QueryBuilder $builder, string $biodataCode): BuilderContract
    {
        $attribute = UserResourceInterface::ATTRIBUTE_BIODATACODE;

        return $builder->where(DB::raw("BINARY `$attribute`"), $biodataCode);
    }
}
