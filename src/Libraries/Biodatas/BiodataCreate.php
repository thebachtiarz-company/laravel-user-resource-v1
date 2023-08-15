<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Libraries\Biodatas;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Libraries\AbstractAccountLibrary;

class BiodataCreate extends AbstractAccountLibrary implements CurlInterface
{
    // ? Public Methods

    /**
     * Create new biodata
     *
     * @param array $data
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setSubUrl('biodata/create')->setBody($data)->post();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
