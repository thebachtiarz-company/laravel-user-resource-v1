<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Services;

use TheBachtiarz\Base\App\Libraries\Paginator\Params\PaginatorParam;
use TheBachtiarz\Base\App\Libraries\Search\Output\SearchResultOutputInterface;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInput;
use TheBachtiarz\Base\App\Libraries\Search\Params\QuerySearchInputInterface;
use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\UserResource\Models\UserResource;
use TheBachtiarz\UserResource\Repositories\UserResourceRepository;
use Throwable;

use function app;
use function assert;

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
            $input = app(QuerySearchInput::class);
            assert($input instanceof QuerySearchInputInterface);

            $input->setModel(app(UserResource::class));
            $input->setPerPage(PaginatorParam::getPerPage());
            $input->setCurrentPage(PaginatorParam::getCurrentPage());

            $search = $this->userResourceRepository->search($input);
            assert($search instanceof SearchResultOutputInterface);

            $resultPaginate = $search->getPaginate();
            $resultPaginate->setDataSort(PaginatorParam::getResultSortOptions(asMultiple: true));

            $result = $resultPaginate->toArray();

            $this->setResponseData(message: 'List resource', data: $result, httpCode: 200);

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
