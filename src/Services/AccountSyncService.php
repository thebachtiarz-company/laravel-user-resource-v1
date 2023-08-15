<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Services;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\Base\App\Helpers\CarbonHelper;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;
use TheBachtiarz\UserResource\Models\UserResource;
use Throwable;

use function assert;

class AccountSyncService extends AccountService
{
    // ? Public Methods

    /**
     * Execute synchronize user resources
     *
     * @return array
     */
    public function execute(): array
    {
        try {
            $builder = UserResource::query();
            assert($builder instanceof EloquentBuilder || $builder instanceof QueryBuilder);
            $builder->whereDate(
                column: UserResourceInterface::ATTRIBUTE_CREATEDAT,
                operator: '<',
                value: CarbonHelper::dbDateTimeNowTimezone(),
            );

            $resources = $builder->get();

            foreach ($resources->all() ?? [] as $key => $resource) {
                assert($resource instanceof UserResourceInterface);
                $this->accountBiodataLatest(accountCode: $resource->getAccountCode());
            }

            $this->setResponseData(message: 'Successfully synchronize user resources');

            return $this->serviceResult(status: true, message: 'Successfully synchronize user resources');
        } catch (Throwable $th) {
            $this->log($th);
            $this->setResponseData(message: $th->getMessage(), status: 'error', httpCode: 202);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
