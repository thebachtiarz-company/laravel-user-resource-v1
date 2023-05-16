<?php

namespace TheBachtiarz\UserResource\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;
use TheBachtiarz\UserResource\Models\UserResource;

class UserResourceRepository extends AbstractRepository
{
    //

    // ? Public Methods
    /**
     * Get by id
     *
     * @param integer $id
     * @return UserResourceInterface
     */
    public function getById(int $id): UserResourceInterface
    {
        $resource = UserResource::find($id);

        if (!$resource) throw new ModelNotFoundException("Resource with id '$id' not found");

        return $resource;
    }

    /**
     * Get by account code
     *
     * @param string $accountCode
     * @return UserResourceInterface
     */
    public function getByAccountCode(string $accountCode): UserResourceInterface
    {
        $resource = UserResource::getByAccountCode($accountCode)->first();

        if (!$resource) throw new ModelNotFoundException("Resource with account '$accountCode' not found");

        return $resource;
    }

    /**
     * Get by biodata code
     *
     * @param string $biodataCode
     * @return UserResourceInterface
     */
    public function getByBiodataCode(string $biodataCode): UserResourceInterface
    {
        $resource = UserResource::getByBiodataCode($biodataCode)->first();

        if (!$resource) throw new ModelNotFoundException("Resource with biodata '$biodataCode' not found");

        return $resource;
    }

    /**
     * Get list user resource
     *
     * @return Collection<UserResourceInterface>
     */
    public function getListResource(): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Builder $resources */
        $resources = UserResource::query();

        return $resources->get();
    }

    /**
     * Create new resource
     *
     * @param UserResourceInterface $userResourceInterface
     * @return UserResourceInterface
     */
    public function create(UserResourceInterface $userResourceInterface): UserResourceInterface
    {
        /** @var Model $userResourceInterface */
        /** @var UserResourceInterface $create */
        $create = $this->createFromModel($userResourceInterface);

        if (!$create) throw new ModelNotFoundException("Failed to create new resource");

        return $create;
    }

    /**
     * Save current resource
     *
     * @param UserResourceInterface $userResourceInterface
     * @return UserResourceInterface
     */
    public function save(UserResourceInterface $userResourceInterface): UserResourceInterface
    {
        /** @var Model|UserResourceInterface $userResourceInterface */
        $resource = $userResourceInterface->save();

        if (!$resource) throw new ModelNotFoundException("Failed to save current resource");

        return $userResourceInterface;
    }

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById(int $id): bool
    {
        /** @var Model|UserResourceInterface $resource */
        $resource = $this->getById($id);

        return $resource->delete();
    }

    /**
     * Delete by acount code
     *
     * @param string $accountCode
     * @return boolean
     */
    public function deleteByAccountCode(string $accountCode): bool
    {
        /** @var Model|UserResourceInterface $resource */
        $resource = $this->getByAccountCode($accountCode);

        return $this->deleteById($resource->getId());
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
