<?php

namespace TheBachtiarz\UserResource\Traits\Model;

use TheBachtiarz\Base\App\Helpers\CarbonHelper;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;

/**
 * User Resource Map Trait
 */
trait UserResourceMapTrait
{
    //

    /**
     * Get resource simple list
     *
     * @return array
     */
    public function simpleListMap(): array
    {
        /** @var UserResourceInterface $this */
        return [
            'account' => $this->getAccountCode(),
            'biodata' => $this->getBiodataCode(),
            'attributes' => json_decode($this->getDataCache(), true),
            'created' => CarbonHelper::anyConvDateToTimestamp($this->getCreatedAt()),
            'updated' => CarbonHelper::anyConvDateToTimestamp($this->getUpdatedAt())
        ];
    }
}
