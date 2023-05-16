<?php

namespace TheBachtiarz\UserResource\Services;

use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\UserResource\Repositories\UserResourceRepository;

class ResourceManagerService extends AbstractService
{
    //

    /**
     * Constructor
     *
     * @param UserResourceRepository $userResourceRepository
     */
    public function __construct(
        protected UserResourceRepository $userResourceRepository
    ) {
        $this->userResourceRepository = $userResourceRepository;
    }

    // ? Public Methods
    /**
     * Get list resource
     *
     * @return array
     */
    public function getListResource(): array
    {
        try {
            $resources = $this->userResourceRepository->getListResource();

            $result = [...array_map(
                fn ($resource): array => $resource->simpleListMap(),
                $resources->all()
            )];

            $this->setResponseData(message: 'List resource', data: $result);
            return $this->serviceResult(status: true, message: 'List resource', data: $result);
        } catch (\Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
