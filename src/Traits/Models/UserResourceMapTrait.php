<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Traits\Models;

use TheBachtiarz\Base\App\Helpers\CarbonHelper;
use TheBachtiarz\UserResource\Models\UserResource;

use function array_merge;
use function array_unique;
use function json_decode;

/**
 * User Resource Map Trait
 */
trait UserResourceMapTrait
{
    /**
     * Get resource simple list
     *
     * @return array
     */
    public function simpleListMap(array $attributes = []): array
    {
        /** @var UserResource $this */

        $returnAttributes = [
            'account',
            'biodata',
            'attributes',
            'created',
            'updated',
        ];

        $this->setData(attribute: 'account', value: $this->getAccountCode());
        $this->setData(attribute: 'biodata', value: $this->getBiodataCode());
        $this->setData(attribute: 'attributes', value: json_decode($this->getDataCache(), true));
        $this->setData(attribute: 'created', value: CarbonHelper::anyConvDateToTimestamp($this->getCreatedAt()));
        $this->setData(attribute: 'updated', value: CarbonHelper::anyConvDateToTimestamp($this->getUpdatedAt()));

        return $this->only(attributes: array_unique(array_merge($returnAttributes, $attributes)));
    }

    /**
     * Get resource simple list
     *
     * @return array
     */
    public function simpleMap(): array
    {
        return $this->simpleListMap();
    }
}
