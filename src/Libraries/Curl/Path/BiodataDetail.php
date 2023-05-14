<?php

namespace TheBachtiarz\UserResource\Libraries\Curl\Path;

use TheBachtiarz\Base\App\Libraries\Curl\CurlInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\UserResource\Interfaces\Config\CurlRestInterface;
use TheBachtiarz\UserResource\Libraries\Curl\AbstractCurl;

class BiodataDetail extends AbstractCurl implements CurlInterface
{
    //

    /**
     * Account detail
     *
     * @param array $data
     * @return CurlResponseInterface
     */
    public function execute(array $data = []): CurlResponseInterface
    {
        return $this->setPath(CurlRestInterface::SUB_BIODATA_DETAIL)->setBody($data)->post();
    }
}
