<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Biodatas;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class BiodataDetail extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Get detail biodata
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('biodata/detail')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
