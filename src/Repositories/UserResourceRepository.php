<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;
use TheBachtiarz\UserResource\Models\UserResource;

use function app;
use function assert;

class UserResourceRepository extends AbstractRepository
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelEntity = app(UserResource::class);

        parent::__construct();
    }

    // ? Public Methods

    /**
     * Get by account code
     */
    public function getByAccountCode(string $accountCode): UserResourceInterface
    {
        $resource = UserResource::getByAccountCode($accountCode)->first();

        if (! $resource) {
            throw new ModelNotFoundException("Resource with account '$accountCode' not found");
        }

        return $resource;
    }

    /**
     * Get by biodata code
     */
    public function getByBiodataCode(string $biodataCode): UserResourceInterface
    {
        $resource = UserResource::getByBiodataCode($biodataCode)->first();

        if (! $resource) {
            throw new ModelNotFoundException("Resource with biodata '$biodataCode' not found");
        }

        return $resource;
    }

    public function search(QuerySearchInputInterface $querySearchInputInterface): SearchResultOutputInterface
    {
        if (! $querySearchInputInterface->getMapMethod()) {
            $querySearchInputInterface->setMapMethod('simpleMap');
        }

        return parent::search($querySearchInputInterface);
    }

    /**
     * Create new resource
     */
    public function create(UserResourceInterface $userResourceInterface): UserResourceInterface
    {
        /** @var Model $userResourceInterface */
        $create = $this->createFromModel($userResourceInterface);
        assert($create instanceof UserResourceInterface);

        if (! $create) {
            throw new ModelNotFoundException('Failed to create new resource');
        }

        return $create;
    }

    /**
     * Save current resource
     */
    public function save(UserResourceInterface $userResourceInterface): UserResourceInterface
    {
        /** @var Model|UserResourceInterface $userResourceInterface */
        $resource = $userResourceInterface->save();

        if (! $resource) {
            throw new ModelNotFoundException('Failed to save current resource');
        }

        return $userResourceInterface;
    }

    /**
     * Delete by acount code
     */
    public function deleteByAccountCode(string $accountCode): bool
    {
        $resource = $this->getByAccountCode($accountCode);
        assert($resource instanceof Model || $resource instanceof UserResourceInterface);

        return $this->deleteById($resource->getId());
    }

    // ? Protected Methods

    protected function getByIdErrorMessage(): string|null
    {
        return "Resource with id '%s' not found!.";
    }

    protected function createOrUpdateErrorMessage(): string|null
    {
        return 'Failed to %s resource';
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
