<?php

namespace Codeboxr\PathaoCourier\Apis;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use Codeboxr\PathaoCourier\Exceptions\PathaoException;

class BaseApi
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Client
     */
    private $request;

    /**
     * @var array
     */
    private $headers;

    public function __construct()
    {
        $this->setBaseUrl();
        $this->setHeaders();
        $this->request = new Client([
            'base_uri' => $this->baseUrl,
            'headers'  => $this->headers
        ]);
    }

    /**
     * Set Base Url on sandbox mode
     */
    private function setBaseUrl()
    {
        if (config("pathao.sandbox") == true) {
            $this->baseUrl = "https://hermes-api.p-stageenv.xyz";
        } else {
            $this->baseUrl = "https://api-hermes.pathaointernal.com";
        }
    }

    /**
     * Set Default Headers
     */
    private function setHeaders()
    {
        $this->headers = [
            "Accept"       => "application/json",
            "Content-Type" => "application/json",
        ];
    }

    /**
     * Merge Headers
     *
     * @param array $header
     */
    private function mergeHeader($header)
    {
        $this->headers = array_merge($this->headers, $header);
    }

    /**
     * set authentication token
     *
     * @throws PathaoException|GuzzleException
     */
    private function authenticate()
    {
        try {
            $response = $this->send("POST", "aladdin/api/v1/issue-token", [
                "client_id"     => config('pathao.client_id'),
                "client_secret" => config("pathao.client_secret"),
                "username"      => config("pathao.username"),
                "password"      => config("pathao.password"),
                "grant_type"    => "password",
            ]);

            $accessToken = [
                "token"      => "Bearer " . $response->access_token,
                "expires_in" => time() + $response->expires_in
            ];

            Storage::disk('local')->put('pathao_bearer_token.json', json_encode($accessToken));

        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            throw new PathaoException($response->message, $response->code);
        }
    }

    /**
     * Authorization set to header
     *
     * @return $this
     * @throws PathaoException|GuzzleException
     */
    public function authorization()
    {
        $storageExits = Storage::disk('local')->exists('pathao_bearer_token.json');

        if (!$storageExits) {
            $this->authenticate();
        }

        $jsonToken = Storage::get('pathao_bearer_token.json');
        $jsonToken = json_decode($jsonToken);

        if ($jsonToken->expires_in < time()) {
            $this->authenticate();
            $jsonToken = Storage::get('pathao_bearer_token.json');
            $jsonToken = json_decode($jsonToken);
        }

        $this->mergeHeader([
            'Authorization' => $jsonToken->token
        ]);

        return $this;
    }

    /**
     * Sending Request
     *
     * @param string $method
     * @param string $uri
     * @param array $body
     *
     * @return mixed
     * @throws GuzzleException
     * @throws PathaoException
     */
    public function send($method, $uri, $body = [])
    {
        try {
            $response = $this->request->request($method, $uri, [
                "headers" => $this->headers,
                "body"    => json_encode($body)
            ]);
            return json_decode($response->getBody());
        } catch (ClientException $e) {
            if ($e->getCode() == 401) {
                $message = "Unauthorized";
                $errors  = [];
            } else {
                $response = json_decode($e->getResponse()->getBody()->getContents());
                $message  = $response->message;
                $errors   = isset($response->errors) ? $response->errors : [];
            }
            throw new PathaoException($message, $e->getCode(), $errors);
        }
    }

}
