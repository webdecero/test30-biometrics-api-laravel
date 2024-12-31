<?php

namespace App\Http\Services\ApiTerminalsWebsocket;


use Carbon\Carbon;
use GuzzleHttp\Client;

class BaseClient
{
    protected $baseUri;
    protected $headers;
    protected $client;

    // private static $instance;
    // public static function getInstance()
    // {
    //     if (!self::$instance instanceof self) {
    //         self::$instance = new self();
    //     }

    //     return self::$instance;
    // }

    public function __construct($baseUri = null, $bearerToken = null, $config = [])
    {
        if (empty($baseUri)) {
            $wsConfig = config('terminals-websocket.config');
            $baseUri = $wsConfig['host'] . ':' . $wsConfig['port'];
        }

        if (!str_ends_with($baseUri, '/'))
            $baseUri .= '/';

        $this->baseUri = $baseUri;
        $this->headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($bearerToken)) {
            $this->headers['Authorization'] = "Bearer " . $bearerToken;
        }

        $config = array_merge([
            'base_uri' => $this->baseUri,
            'headers' => $this->headers,
            // 'verify' => false,
            // 'debug' => true,
            'http_errors' => false,
        ], $config);

        $this->client = new Client($config);
    }



    public function createToken($clientId, $clientSecret, $scopes = ['*'], $grantType = 'client_credentials')
    {

        $scopes = is_array($scopes) ? $scopes : [$scopes];
        $response = $this->client->request(
            'POST',
            'oauth/token',
            [
                'form_params' => [
                    'grant_type' => $grantType,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'scope' => $scopes
                ]
            ]
        );

        $dataResponse = $response->getBody()->getContents();

        $data = json_decode($dataResponse, true);

        $data['expires'] = Carbon::now()->addSeconds($data['expires_in'])->toDateTimeString();
        ;


        return $data;
    }

    public static function isValidToken(array $token)
    {

        if (!isset($token['access_token']) || empty($token['access_token']))
            return false;

        if (!isset($token['expires']) || empty($token['expires']))
            return false;

        $diffInHours = Carbon::parse($token['expires'])->diffInHours(Carbon::now(), false);

        return ($diffInHours < 0);
    }
}
