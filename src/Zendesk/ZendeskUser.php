<?php
namespace Zendesk;
use GuzzleHttp\Client;

/**
 *
 */
class ZendeskUser
{
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
                    'Authorization' => "{$this->connekt->getAuthenticateString()}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return  json_decode($response->getBody(), true);
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }

    public function getUserByName()
    {

    }

    public function getUserById($id)
    {

    }
}