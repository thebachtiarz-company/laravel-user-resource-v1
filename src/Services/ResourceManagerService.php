<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Services;

use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\UserResource\Repositories\UserResourceRepository;
use Throwable;

use function array_map;

class ResourceManagerService extends AbstractService
{
    /**
     * Constructor
     */
    public function __construct(
        protected UserResourceRepository $userResourceRepository,
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

            $result = [
                ...array_map(
                    static fn ($resource): array => $resource->simpleListMap(),
                    $resources->all(),
                ),
            ];

            $this->setResponseData(message: 'List resource', data: $result);

            return $this->serviceResult(status: true, message: 'List resource', data: $result);
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
