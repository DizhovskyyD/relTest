<?php

declare(strict_types=1);

namespace Zendesk;

use GuzzleHttp\Client;

class ZendeskTicket
{
    private Zendesk $connekt;
    private $client;

    public function __construct($connekt)
    {
        $this->connekt=$connekt;
        $this->client = new Client();
    }

    public function getAllTicket()
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}tickets.json",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "{$this->connekt->getAuthenticateString()}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return  json_decode((string) $response->getBody(), true);;
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }

    public function getTicketById($id)
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}tickets/{$id}",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "{$this->connekt->getAuthenticateString()}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return  json_decode((string) $response->getBody(), true);;
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }
}