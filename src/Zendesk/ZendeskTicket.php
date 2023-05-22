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

    public function getTicketInfoById($id)
    {
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}tickets/{$id}",[
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

    public function getCountTickets()
    {
        $ticketsInfo = $this->getAllTicket();
        return $ticketsInfo["count"];
    }

    public function getAllTicketsId()
    {
        $ticketsInfo = $this->getAllTicket();
        $ticketsId = [];

        foreach ($ticketsInfo["tickets"] as $ticket){
            $ticketsId[] = $ticket["id"];
        }

        return $ticketsId;
    }

    /**
     * @param $id - Айді тікета
     * @param $flag - флаг для вказання формату данних що передадуться назад "" або "str" - в вигляді строки, "arr" - асоціативний массив
     *
     * @return string|void повертає стрічку
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllCommentsInTicket($id,$flag='')
    {
        $comments= [];
        try {
            $response = $this->client->request('GET',"{$this->connekt->getBaseUri()}tickets/{$id}/comments",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($this->connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $comments =  json_decode((string) $response->getBody(), true);

                if ($flag === "str" || $flag === ''){
                    foreach ($comments["comments"] as $comment){
                        $comments[] = (string)
                            "comment: ID: ".$comment["id"].
                            "; AuthorID:".$comment["author_id"].
                            "; Text:".$comment["html_body"].";";
                    }
                }elseif ($flag === "arr"){
                    foreach ($comments["comments"] as $comment){
                        $comments[] = [
                            "ID" => $comment["id"],
                            "AuthorID" => $comment["author_id"],
                            "Text" => $comment["html_body"]
                        ];
                    }
                }
                return $comments;
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }
}