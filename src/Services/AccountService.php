<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Services;

use TheBachtiarz\Base\App\Http\Requests\Rules\PaginateRule;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;
use TheBachtiarz\UserResource\Libraries\CurlAccountLibrary;
use TheBachtiarz\UserResource\Models\UserResource;
use TheBachtiarz\UserResource\Repositories\UserResourceRepository;

use function assert;
use function collect;
use function json_encode;
use function mb_strlen;

class AccountService extends AbstractService
{
    /**
     * Original account code
     */
    private string|null $accountOrigin = null;

    /**
     * Constructor
     */
    public function __construct(
        protected CurlAccountLibrary $curlAccountLibrary,
        protected UserResourceRepository $userResourceRepository,
    ) {
    }

    // ? Public Methods

    /**
     * Get detail account
     *
     * @return void
     */
    public function accountDetail(
        string $accountCode,
        string $perPage = '15',
        string $currentpage = '1',
        string $sortOptions = '{}',
    ): array {
        return $this->processResponseHandler(
            curlResponseInterface: $this->curlAccountLibrary->execute(
                path: CurlAccountLibrary::ACCOUNT_DETAIL_PATH,
                data: [
                    'account_code' => $accountCode,
                    PaginateRule::INPUT_PERPAGE => $perPage,
                    PaginateRule::INPUT_CURRENTPAGE => $currentpage,
                    PaginateRule::INPUT_SORTOPTIONS => $sortOptions,
                ],
            ),
        );
    }

    /**
     * Get latessst biodata from account
     *
     * @return array
     */
    public function accountBiodataLatest(string $accountCode): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::ACCOUNT_BIODATA_LATEST_PATH,
            data: ['account_code' => $accountCode],
        );

        if ($process->getStatus() === 'success') {
            $this->syncLocalResource(
                account: $process->getData('account'),
                biodata: $process->getData('biodata'),
                attributes: $process->getData('attributes'),
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    /**
     * Create new account with biodata
     *
     * @return array
     */
    public function accountCreateWithBiodata(string $bulkAttribute): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::ACCOUNT_CREATE_WITH_BIODATA_PATH,
            data: ['bulk_attribute_value' => $bulkAttribute],
        );

        if ($process->getStatus() === 'success') {
            $this->syncLocalResource(
                account: $process->getData('account'),
                biodata: @$process->getData('biodatas')[0]['biodata'],
                attributes: @$process->getData('biodatas')[0]['attributes'],
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    /**
     * Update current account
     *
     * @return array
     */
    public function accountUpdate(string $accountCode): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::ACCOUNT_UPDATE_PATH,
            data: ['account_code' => $accountCode],
        );

        if ($process->getStatus() === 'success') {
            $this->accountOrigin = $accountCode;

            $this->syncLocalResource(
                account: $process->getData('account'),
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    /**
     * Get detail biodata
     *
     * @return array
     */
    public function biodataDetail(string $biodataCode): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::BIODATA_DETAIL_PATH,
            data: ['biodata_code' => $biodataCode],
        );

        if ($process->getStatus() === 'success') {
            $this->syncLocalResource(
                account: $process->getData('account'),
                biodata: $process->getData('biodata'),
                attributes: $process->getData('attributes'),
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    /**
     * Get biodata attribute history
     *
     * @return void
     */
    public function biodataAttributeHistory(
        string $biodataCode,
        string $attribute,
        string $perPage = '15',
        string $currentpage = '1',
        string $sortOptions = '{}',
    ): array {
        return $this->processResponseHandler(
            curlResponseInterface: $this->curlAccountLibrary->execute(
                path: CurlAccountLibrary::BIODATA_ATTRIBUTE_HISTORY_PATH,
                data: [
                    'biodata_code' => $biodataCode,
                    'attribute' => $attribute,
                    PaginateRule::INPUT_PERPAGE => $perPage,
                    PaginateRule::INPUT_CURRENTPAGE => $currentpage,
                    PaginateRule::INPUT_SORTOPTIONS => $sortOptions,
                ],
            ),
        );
    }

    /**
     * Create new biodata
     *
     * @return array
     */
    public function biodataCreate(string $accountCode, string $bulkAttribute): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::BIODATA_CREATE_PATH,
            data: [
                'account_code' => $accountCode,
                'bulk_attribute_values' => $bulkAttribute,
            ],
        );

        if ($process->getStatus() === 'success') {
            $this->syncLocalResource(
                account: $accountCode,
                biodata: $process->getData('biodata'),
                attributes: $process->getData('attributes'),
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    /**
     * Update current biodata
     *
     * @return array
     */
    public function biodataUpdate(string $biodataCode, string $bulkAttribute): array
    {
        $process = $this->curlAccountLibrary->execute(
            path: CurlAccountLibrary::BIODATA_UPDATE_PATH,
            data: [
                'biodata_code' => $biodataCode,
                'bulk_attribute_values' => $bulkAttribute,
            ],
        );

        if ($process->getStatus() === 'success') {
            $this->syncLocalResource(
                account: $process->getData('account'),
                biodata: $process->getData('biodata'),
                attributes: $process->getData('attributes'),
            );
        }

        return $this->processResponseHandler(curlResponseInterface: $process);
    }

    // ? Protected Methods

    /**
     * Handler process response
     *
     * @return array
     */
    protected function processResponseHandler(CurlResponseInterface $curlResponseInterface): array
    {
        $this->setResponseData(
            message: $curlResponseInterface->getMessage(),
            data: $curlResponseInterface->getData(),
            status: $curlResponseInterface->getStatus(),
            httpCode: $curlResponseInterface->getHttpCode(),
        );

        return $curlResponseInterface->toArray();
    }

    /**
     * Sync local resource
     *
     * @param array $attributes
     */
    protected function syncLocalResource(string $account, string $biodata = '', array $attributes = []): bool
    {
        $resource = UserResource::getByAccountCode($this->accountOrigin ?? $account)->first();
        assert($resource instanceof UserResourceInterface || $resource === null);

        if ($resource?->getId()) {
            PROCESS_UPDATE:

            if ($this->accountOrigin) {
                $resource->setAccountCode($account);
            }

            if (mb_strlen($biodata)) {
                $resource->setBiodataCode($biodata);
            }

            if (collect($attributes)->count()) {
                $resource->setDataCache(json_encode($attributes));
            }

            $this->userResourceRepository->save($resource);

            goto PROCESS_FINISH;
        }

        PROCESS_CREATE:
        $resource = new UserResource();
        assert($resource instanceof UserResourceInterface || $resource === null);
        $resource->setAccountCode($account);
        $resource->setBiodataCode($biodata);
        $resource->setDataCache(json_encode($attributes));

        $this->userResourceRepository->create($resource);

        PROCESS_FINISH:

        return true;
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
