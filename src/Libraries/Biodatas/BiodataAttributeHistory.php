<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Biodatas;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class BiodataAttributeHistory extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Get biodata attribute history
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('biodata/attribute-history')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
