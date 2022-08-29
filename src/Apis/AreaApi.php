<?php

namespace Codeboxr\PathaoCourier\Apis;

use GuzzleHttp\Exception\GuzzleException;
use Codeboxr\PathaoCourier\Exceptions\PathaoException;

class AreaApi extends BaseApi
{
    /**
     * get city List
     *
     * @return mixed
     * @throws PathaoException
     * @throws GuzzleException
     */
    public function city()
    {
        $response = $this->authorization()->send("GET", "aladdin/api/v1/countries/1/city-list");
        return $response->data;
    }

    /**
     * Get zone list city wise
     *
     * @param int $cityId
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function zone($cityId)
    {
        $response = $this->authorization()->send("GET", "aladdin/api/v1/cities/{$cityId}/zone-list");
        return $response->data;
    }

    /**
     * Get area list zone wise
     *
     * @param int $zoneId
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function area($zoneId)
    {
        $response = $this->authorization()->send("GET", "aladdin/api/v1/zones/{$zoneId}/area-list");
        return $response->data;
    }
}
