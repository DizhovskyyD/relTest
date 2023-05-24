<?php

declare(strict_types=1);

namespace Zendesk;

use Exception;
use GuzzleHttp\Client;

class TicketPage
{
    private $pageNumber;
    private Zendesk $connekt;

    public function __construct($connekt, $pageNumber = '')
    {
        $this->connekt = $connekt;
        $this->pageNumber = $pageNumber;
    }

    public function getAllTicket()
    {
        $client = new Client();

        try {
            if ($this->pageNumber === '') {
                $response = $client->request('GET', "{$this->connekt->getBaseUri()}tickets.json", [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                    ],
                ]);
            } else {
                $response = $client->request(
                    'GET',
                    "{$this->connekt->getBaseUri()}tickets.json?page={$this->pageNumber}",
                    [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                        ],
                    ]
                );
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

    public function getAllTicketsId()
    {
        $ticketsInfo = $this->getAllTicket();
        $ticketsId = [];

        foreach ($ticketsInfo["tickets"] as $ticket) {
            $ticketsId[] = $ticket["id"];
        }

        return $ticketsId;
    }
}