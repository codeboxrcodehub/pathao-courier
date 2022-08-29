<?php

namespace Codeboxr\PathaoCourier\Apis;

use GuzzleHttp\Exception\GuzzleException;
use Codeboxr\PathaoCourier\Exceptions\PathaoException;

class OrderApi extends BaseApi
{
    /**
     * Order Create
     *
     * @param array $array
     *
     * @return mixed
     * @throws PathaoException
     * @throws GuzzleException
     */
    public function create($array)
    {
        $response = $this->authorization()->send("POST", "aladdin/api/v1/orders", $array);
        return $response->data;
    }

    /**
     * Order Details
     *
     * @param string $consignmentId
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function orderDetails($consignmentId)
    {
        $response = $this->authorization()->send("GET", "aladdin/api/v1/orders/{$consignmentId}");
        return $response->data;
    }

    /**
     * Delivery price calculation
     *
     * @param array $array
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function priceCalculation($array)
    {
        $response = $this->authorization()->send("POST", "aladdin/api/v1/merchant/price-plan", $array);
        return $response->data;
    }
}
