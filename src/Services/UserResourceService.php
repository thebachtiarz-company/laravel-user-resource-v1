<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Services;

use Exception;
use TheBachtiarz\Base\App\Helpers\CarbonHelper;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\Base\App\Services\AbstractService;
use TheBachtiarz\UserResource\Interfaces\Config\CurlRestInterface;
use TheBachtiarz\UserResource\Interfaces\Models\UserResourceInterface;
use TheBachtiarz\UserResource\Libraries\Curl\UserResourceRestLibrary;
use TheBachtiarz\UserResource\Models\UserResource;
use TheBachtiarz\UserResource\Repositories\UserResourceRepository;
use Throwable;

use function assert;
use function json_decode;
use function json_encode;
use function now;

class UserResourceService extends AbstractService
{
    /**
     * Constructor
     */
    public function __construct(
        protected UserResourceRepository $userResourceRepository,
        protected UserResourceRestLibrary $userResourceRestLibrary,
    ) {
        $this->userResourceRepository  = $userResourceRepository;
        $this->userResourceRestLibrary = $userResourceRestLibrary;
    }

    // ? Public Methods

    /**
     * Get list biodata from account
     *
     * @return array
     */
    public function getAccountBiodataList(string $accountCode, int $currentPage = 1, int $perPage = 10): array
    {
        try {
            $process = $this->userResourceRestLibrary->execute(
                CurlRestInterface::ACCOUNT_DETAIL_PATH_NAME,
                [
                    'account_code' => $accountCode,
                    'currentPage' => $currentPage,
                    'perPage' => $perPage,
                    'sortAttribute' => 'mode',
                ],
            );

            if (! $process->getStatus()) {
                throw new Exception($process->getMessage());
            }

            $this->setResponseData(message: $process->getMessage(), data: $process->getData());

            return $this->serviceResult(status: true, message: $process->getMessage(), data: $process->getData());
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Get account biodata latest
     *
     * @return array
     */
    public function getAccountBiodata(string $accountCode): array
    {
        try {
            $process = $this->userResourceRestLibrary->execute(
                CurlRestInterface::ACCOUNT_BIODATA_LATEST_PATH_NAME,
                ['account_code' => $accountCode],
            );

            if (! $process->getStatus()) {
                throw new Exception($process->getMessage());
            }

            $this->createOrUpdateLocalResource('account', $accountCode, $process);

            $this->setResponseData(message: 'Account biodata latest', data: $this->getSimpleAttributes($process));

            return $this->serviceResult(status: true, message: 'Account biodata latest', data: $this->getSimpleAttributes($process));
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Create new account
     *
     * @param array $bulkAttributeValue
     *
     * @return array
     */
    public function createAccount(array $bulkAttributeValue): array
    {
        try {
            $createAccount = $this->userResourceRestLibrary->execute(
                CurlRestInterface::ACCOUNT_CREATE_PATH_NAME,
                ['bulk_attribute_value' => json_encode($bulkAttributeValue)],
            );

            if (! $createAccount->getStatus()) {
                throw new Exception($createAccount->getMessage());
            }

            $accountBiodataLatest = $this->userResourceRestLibrary->execute(
                CurlRestInterface::ACCOUNT_BIODATA_LATEST_PATH_NAME,
                ['account_code' => $createAccount->getData('code')],
            );

            if (! $accountBiodataLatest->getStatus()) {
                throw new Exception($accountBiodataLatest->getMessage());
            }

            $this->createOrUpdateLocalResource('account', $createAccount->getData('code'), $accountBiodataLatest);

            $this->setResponseData(message: 'Account create', data: $this->getSimpleAttributes($accountBiodataLatest));

            return $this->serviceResult(status: true, message: 'Account create', data: $this->getSimpleAttributes($accountBiodataLatest));
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Update account
     *
     * @return array
     */
    public function updateAccount(string $accountCode): array
    {
        try {
            $process = $this->userResourceRestLibrary->execute(
                CurlRestInterface::ACCOUNT_UPDATE_PATH_NAME,
                ['account_code' => $accountCode],
            );

            if (! $process->getStatus()) {
                throw new Exception($process->getMessage());
            }

            $resource = UserResource::getByAccountCode($accountCode)->first();
            assert($resource instanceof UserResourceInterface || $resource === null);

            if ($resource?->getId()) {
                $resource->setAccountCode($process->getData('code'));
                $this->userResourceRepository->save($resource);
            } else {
                $accountBiodataLatest = $this->userResourceRestLibrary->execute(
                    CurlRestInterface::ACCOUNT_BIODATA_LATEST_PATH_NAME,
                    ['account_code' => $accountCode],
                );

                if (! $accountBiodataLatest->getStatus()) {
                    throw new Exception($accountBiodataLatest->getMessage());
                }

                $this->createOrUpdateLocalResource('account', $accountCode, $accountBiodataLatest);
            }

            $updatedResult = [
                'old_account' => $accountCode,
                'new_account' => $process->getData('code'),
            ];

            $this->setResponseData(message: 'Update account', data: $updatedResult);

            return $this->serviceResult(status: true, message: 'Update account', data: $updatedResult);
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Get biodata attributes
     *
     * @return array
     */
    public function getBiodataAttributes(string $biodataCode): array
    {
        try {
            $resource = $this->userResourceRepository->getByBiodataCode($biodataCode);

            $resource = $this->syncBiodataExpired($resource);

            $biodataDetail = json_decode($resource->getDataCache(), true);

            $this->setResponseData(message: 'Biodata detail', data: $biodataDetail);

            return $this->serviceResult(status: true, message: 'Biodata detail', data: $biodataDetail);
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Get biodata attribute history
     *
     * @return array
     */
    public function getBiodataAttributeHistory(string $biodataCode, string $attributeName, int $currentPage = 1, int $perPage = 10): array
    {
        try {
            $process = $this->userResourceRestLibrary->execute(
                CurlRestInterface::BIODATA_ATTRIBUTE_HISTORY_PATH_NAME,
                [
                    'biodata_code' => $biodataCode,
                    'attribute' => $attributeName,
                    'currentPage' => $currentPage,
                    'perPage' => $perPage,
                    'sortAttribute' => 'mode',
                ],
            );

            if (! $process->getStatus()) {
                throw new Exception($process->getMessage());
            }

            $this->setResponseData(message: 'Biodata attribute history', data: $process->getData());

            return $this->serviceResult(status: true, message: 'Biodata attribute history', data: $process->getData());
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Create biodata from account
     *
     * @param array $bulkAttributeValue
     *
     * @return array
     */
    public function createBiodata(string $accountCode, array $bulkAttributeValue): array
    {
        try {
            $createBiodata = $this->userResourceRestLibrary->execute(
                CurlRestInterface::BIODATA_CREATE_PATH_NAME,
                [
                    'account_code' => $accountCode,
                    'bulk_attribute_value' => json_encode($bulkAttributeValue),
                ],
            );

            if (! $createBiodata->getStatus()) {
                throw new Exception($createBiodata->getMessage());
            }

            $this->createOrUpdateLocalResource('account', $createBiodata->getData('account'), $createBiodata);

            $this->setResponseData(message: 'Create biodata', data: $this->getSimpleAttributes($createBiodata));

            return $this->serviceResult(status: true, message: 'Create biodata', data: $this->getSimpleAttributes($createBiodata));
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    /**
     * Update biodata
     *
     * @param array $bulkAttributeValue
     *
     * @return array
     */
    public function updateBiodata(string $biodataCode, array $bulkAttributeValue): array
    {
        try {
            $updateBiodata = $this->userResourceRestLibrary->execute(
                CurlRestInterface::BIODATA_UPDATE_PATH_NAME,
                [
                    'biodata_code' => $biodataCode,
                    'bulk_attribute_value' => json_encode($bulkAttributeValue),
                ],
            );

            if (! $updateBiodata->getStatus()) {
                throw new Exception($updateBiodata->getMessage());
            }

            $this->createOrUpdateLocalResource('biodata', $updateBiodata->getData('code'), $updateBiodata);

            $this->setResponseData(message: 'Update biodata', data: $this->getSimpleAttributes($updateBiodata));

            return $this->serviceResult(status: true, message: 'Update biodata', data: $this->getSimpleAttributes($updateBiodata));
        } catch (Throwable $th) {
            $this->log($th);

            return $this->serviceResult(message: $th->getMessage());
        }
    }

    // ? Protected Methods

    /**
     * Get biodata detail attributes from API
     */
    protected function getApiBiodataAttributes(string $biodataCode): CurlResponseInterface
    {
        $process = $this->userResourceRestLibrary->execute(
            CurlRestInterface::BIODATA_DETAIL_PATH_NAME,
            ['biodata_code' => $biodataCode],
        );
        assert($process instanceof CurlResponseInterface);

        if (! $process->getStatus()) {
            throw new Exception($process->getMessage());
        }

        return $process;
    }

    /**
     * Synchronize biodata cache if expired
     */
    protected function syncBiodataExpired(UserResourceInterface $userResourceInterface): UserResourceInterface
    {
        if (
            CarbonHelper::anyConvDateToTimestamp(CarbonHelper::dbGetFullDateAddDays(1, $userResourceInterface->getUpdatedAt()))
            >= CarbonHelper::anyConvDateToTimestamp(now())
        ) {
            $resourceBiodataAPI = $this->getApiBiodataAttributes($userResourceInterface->getBiodataCode());
            $userResourceInterface->setDataCache(json_encode($this->getSimpleAttributes($resourceBiodataAPI)));
            $userResourceInterface = $this->userResourceRepository->save($userResourceInterface);
        }

        return $userResourceInterface;
    }

    // ? Private Methods

    /**
     * Create or update local resource
     */
    private function createOrUpdateLocalResource(string $type, string $code, CurlResponseInterface $curlResponseInterface): bool
    {
        try {
            $resource = null;
            assert($resource instanceof UserResourceInterface || $resource === null);

            switch ($type) {
                case 'account':
                    $resource = UserResource::getByAccountCode($code)->first();
                    break;
                case 'biodata':
                    $resource = UserResource::getByBiodataCode($code)->first();
                    break;
                default:
                    throw new Exception('Update resource type undefined');

                    break;
            }

            if ($resource?->getId()) {
                $resource->setAccountCode($curlResponseInterface->getData('account'));
                $resource->setBiodataCode($curlResponseInterface->getData('code'));
                $resource->setDataCache(json_encode($this->getSimpleAttributes($curlResponseInterface)));
                $this->userResourceRepository->save($resource);
            } else {
                $userResourcePrepare = (new UserResource())
                    ->setAccountCode($curlResponseInterface->getData('account'))
                    ->setBiodataCode($curlResponseInterface->getData('code'))
                    ->setDataCache(json_encode($this->getSimpleAttributes($curlResponseInterface)));
                assert($userResourcePrepare instanceof UserResourceInterface);
                $this->userResourceRepository->create($userResourcePrepare);
            }

            return true;
        } catch (Throwable $th) {
            $this->log($th);

            return false;
        }
    }

    /**
     * Get simple attributes from API
     *
     * @return array
     */
    private function getSimpleAttributes(CurlResponseInterface $curlResponseInterface): array
    {
        $attributes = [];

        foreach ($curlResponseInterface->getData('attributes') ?? [] as $key => $value) {
            $attributes[$value['name']] = $value['value'];
        }

        return $attributes;
    }

    // ? Getter Modules

    // ? Setter Modules
}
