<?php

declare(strict_types=1);

namespace Zendesk;

use Exception;
use GuzzleHttp\Client;

class TicketsPages
{
    private Zendesk $connekt;

    public function __construct($connekt)
    {
        $this->connekt = $connekt;
    }

    public function paginationAviable(): bool
    {
        $page = $this->getAllTicket();

        return ($page['next_page'] !== null) ? true : false;
    }

    public function getAllPagesNumber()
    {
        $pagesNumber = [];
        if ($this->paginationAviable()) {
            $pagesNumber[] = '1';
            for ($i = 1; ; $i++) {
                $page = $this->getAllTicket($i);

                if ($page['next_page'] !== null) {
                    $pagesNumber[] = str_replace(
                        "{$this->connekt->getBaseUri()}tickets.json?page=",
                        "",
                        $page['next_page']
                    );
                } else {
                    break;
                }
            }
        } else {
            $pagesNumber[] = '1';
        }

        return $pagesNumber;
    }

    public function getAllTicket($pageNumber = '')
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
            } else {
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
}