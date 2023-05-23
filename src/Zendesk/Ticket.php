<?php

declare(strict_types=1);

namespace Zendesk;

use GuzzleHttp\Client;

class Ticket
{
    private $id;
    private $url;
    private $description;
    private $status;
    private $priority;
    private $comments;

    /**
     * @param Zendesk $connekt
     * @param $id
     */
    public function __construct(Zendesk $connekt, $id)
    {
        if($connekt->authenticate()) {
            $this->connect = $connekt;
            $this->id = $id;

            $this->setInfo($connekt, $id);
        }

    }

    /**
     * @param Zendesk $connekt
     * @param $id
     *
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function setInfo(Zendesk $connekt, $id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET',"{$connekt->getBaseUri()}tickets/{$id}",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => (string) ($connekt->getAuthenticateString()),
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $ticketInfo = json_decode((string) $response->getBody(), true)['ticket'];

                $this->setUrl($ticketInfo['url']);
                $this->setDescription($ticketInfo['description']);
                $this->setStatus($ticketInfo['status']);
                $this->setPriority($ticketInfo['priority']);
                $this->setComments($connekt, $id);
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $url
     */
    private function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $description
     */
    private function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $status
     */
    private function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $priority
     */
    private function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Zendesk $connekt
     * @param $id
     *
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function setComments(Zendesk $connekt, $id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET',"{$connekt->getBaseUri()}tickets/{$id}/comments",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $connekt->getAuthenticateString(),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $allComments =  json_decode((string) $response->getBody(), true);
                foreach ($allComments["comments"] as $comment){
                    $comments[] = [
                        "ID" => $comment["id"],
                        "AuthorID" => $comment["author_id"],
                        "Text" => $comment["html_body"]
                    ];
                }
                $this->comments = $comments;
            }

        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }
    }


    public function getComments($flag = '')
    {
        if ($flag === ''){
            $comments = $this->comments;
        }elseif ($flag === 'str'){
            foreach ($this->comments as $comment){
                $comments .=
                    "comment: ID: ".$comment["ID"].
                    "; AuthorID:".$comment["AuthorID"].
                    "; Text:".$comment["Text"].";";
            }
        }

        return $comments;
    }

}