<?php

declare(strict_types=1);

namespace Zendesk;

use GuzzleHttp\Client;

class TicketPage
{

    private Zendesk $connekt;

    public function __construct($connekt)
    {
        $this->connekt=$connekt;
    }

    public function getAllTicket($pageNumber='')
    {
        $client = new Client();

        try {
            if ($pageNumber === '') {
                $response = $client->request('GET', "{$this->connekt->getBaseUri()}tickets.json", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                    ],
                ]);
            }else{
                $response = $client->request('GET', "{$this->connekt->getBaseUri()}tickets.json?page={$pageNumber}", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                    ],
                ]);
            }

            if ($response->getStatusCode() === 200) {
                return json_decode((string) $response->getBody(), true);
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }

    }

    public function getCountTickets()
    {
        $ticketsInfo = $this->getAllTicket();

        return $ticketsInfo["count"];
    }

    public function getAllTicketsId($pageNumber='')
    {
        if ($pageNumber === '') {
            $ticketsInfo = $this->getAllTicket();
        }else{
            $ticketsInfo = $this->getAllTicket($pageNumber);
        }
        $ticketsId = [];

        foreach ($ticketsInfo["tickets"] as $ticket){
            $ticketsId[] = $ticket["id"];
        }

        return $ticketsId;
    }
}