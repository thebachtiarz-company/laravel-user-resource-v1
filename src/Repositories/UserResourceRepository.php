<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;
use TheBachtiarz\UserResource\Models\UserResource;

use function assert;

class UserResourceRepository extends AbstractRepository
{
    // ? Public Methods

    /**
     * Get by id
     */
    public function getById(int $id): UserResourceInterface
    {
        $resource = UserResource::find($id);

        if (! $resource) {
            throw new ModelNotFoundException("Resource with id '$id' not found");
        }

        return $resource;
    }

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

    /**
     * Get list user resource
     *
     * @return Collection<UserResourceInterface>
     */
    public function getListResource(): Collection
    {
        $resources = UserResource::query();
        assert($resources instanceof Builder);

        return $resources->get();
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
     * Delete by id
     */
    public function deleteById(int $id): bool
    {
        $resource = $this->getById($id);
        assert($resource instanceof Model);

        return $resource->delete();
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

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
