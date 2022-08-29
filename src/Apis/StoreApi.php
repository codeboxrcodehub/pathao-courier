<?php

namespace Codeboxr\PathaoCourier\Apis;

use GuzzleHttp\Exception\GuzzleException;
use Codeboxr\PathaoCourier\Exceptions\PathaoException;

class StoreApi extends BaseApi
{
    /**
     *  Get Store List
     *
     * @param int $page
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function list($page = 1)
    {
        $response = $this->authorization()->send("GET", "aladdin/api/v1/stores?page={$page}");
        return $response->data;
    }

    /**
     * Store Create
     *
     * @param array $storeInfo
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function create($storeInfo)
    {
        $response = $this->authorization()->send("POST", "aladdin/api/v1/stores", $storeInfo);
        return $response->data;
    }
}
