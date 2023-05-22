<?php

declare(strict_types=1);

namespace Zendesk;
use GuzzleHttp\Client;


/**
 *
 */
class ZendeskUser{
    private Zendesk $connekt;
    private  $client;

    public function __construct($connekt)
    {
        $this->connekt=$connekt;
        $this->client = new Client();
    }
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

    public function getUserName($id)
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}users/{$id}.json",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return  json_decode((string) $response->getBody(), true)["name"];
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }

    public function getUserEmaile($id)
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}users/{$id}.json",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return  json_decode((string) $response->getBody(), true)["email"];
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }
}