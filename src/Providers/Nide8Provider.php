<?php

namespace MinecraftAuth\Providers;

use function Couchbase\defaultDecoder;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Nide8Provider implements iProvider
{
    protected $client_token;
    protected $server_id;
    protected $http;

    public function __construct()
    {
        $this->http = new Client();
    }

    public function setClientToken($client_token)
    {
        $this->client_token = $client_token;
    }

    public function setServerId($server_id)
    {
        $this->server_id = $server_id;
    }

    public function authenticate(array $data)
    {
        $res = $this->post('authenticate', $data);
        $this->setClientToken($res['clientToken']);

        return $res;
    }

    public function refresh($access_token, $options = [])
    {
        $res = $this->post('refresh', array_merge(['accessToken' => $access_token], $options));

        return $res;
    }

    public function validate($access_token)
    {
        $res = $this->post('validate', ['accessToken' => $access_token], 'raw');

        if ($res->getStatusCode() == 204) {
            return true;
        } else {
            return json_decode($res->getBody(), true);
        }
    }

    public function logout(array $data)
    {
        $res = $this->post('signout', $data, 'raw');

        if ($res->getStatusCode() == 204) {
            return true;
        } else {
            return json_decode($res->getBody(), true);
        }
    }

    public function invalidate($access_token)
    {
        $res = $this->post('invalidate', ['accessToken' => $access_token], 'raw');

        if ($res->getStatusCode() == 204) {
            return true;
        } else {
            return json_decode($res->getBody(), true);
        }
    }

    protected function post($url, $data, $return_type = 'json')
    {
        $url = "https://auth2.nide8.com:233/{$this->server_id}/authserver/{$url}";
        if (!array_key_exists('clientToken', $data) && !empty($this->client_token)) {
            $data['clientToken'] = $this->client_token;
        }
        $res = $this->http->post($url, [
            RequestOptions::JSON => $data
        ]);

        if ($return_type == 'json') {
            return json_decode($res->getBody(), true);
        } else {
            return $res;
        }
    }
}