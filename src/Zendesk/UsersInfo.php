<?php

declare(strict_types=1);

namespace Zendesk;
use GuzzleHttp\Client;


/**
 *
 */
class UsersInfo{
    private Zendesk $connekt;
    private  $client;

    public function __construct($connekt)
    {
        $this->connekt=$connekt;
        $this->client = new Client();
    }

    /**
     * @return mixed|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllUser()
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}users.json",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return  json_decode((string) $response->getBody(), true);
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }

    /**
     * @param $id
     *
     * @return mixed|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfoById($id)
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}users/{$id}.json",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return  json_decode((string) $response->getBody(), true);
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }
}