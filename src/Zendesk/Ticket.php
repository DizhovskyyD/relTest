<?php

declare(strict_types=1);

namespace Zendesk;

use Exception;
use GuzzleHttp\Client;

class Ticket
{
    private $id;
    private $url;
    private $description;
    private $status;
    private $priority;

    private $agentId;
    private $agentName;
    private $agentEmale;

    private $contactId;
    private $contactName;
    private $contactEmale;

    private $groupId;
    private $groupName;

    private $companyId;
    private $companyName;

    private $comments;

    private Zendesk $connekt;

    /**
     * @param Zendesk $connekt
     * @param $id
     */
    public function __construct(Zendesk $connekt, $id)
    {
        $this->connect = $connekt;
        $this->id = $id;
        $this->setInfo($connekt, $id);
    }

    /**
     * @param Zendesk $connekt
     * @param $id
     *
     * @return string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function setInfo($connekt, $id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', "{$connekt->getBaseUri()}tickets/{$id}", [
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

                $this->setAgentInfo($ticketInfo['submitter_id']);
                $this->setContactInfo($ticketInfo['requester_id']);

                $this->setGroupInfo($ticketInfo['group_id']);
                $this->setCompanyInfo($ticketInfo['organization_id']);

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


    public function setAgentInfo($id): void
    {
        $agent = new User($this->connect, $id);

        $this->agentId = $agent->getId();
        $this->agentName = $agent->getName();
        $this->agentEmale = $agent->getEmale();
    }

    public function setContactInfo($id): void
    {
        $contact = new User($this->connect, $id);

        $this->contactId = $contact->getId();
        $this->companyName = $contact->getName();
        $this->contactEmale = $contact->getEmale();
    }

    public function setGroupInfo($id): void
    {
        $group = new Group($this->connect, $id);

        $this->groupId = $group->getId();
        $this->groupName = $group->getName();
    }

    public function setCompanyInfo($id): void
    {
        $company = new Organization($this->connect, $id);

        $this->companyId = $company->getId();
        $this->companyName = $company->getName();
    }

    private function setComments($connekt, $id)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', "{$connekt->getBaseUri()}tickets/{$id}/comments", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $connekt->getAuthenticateString(),
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $allComments = json_decode((string) $response->getBody(), true);
                foreach ($allComments["comments"] as $comment) {
                    $comments[] = [
                        "ID" => $comment["id"],
                        "AuthorID" => $comment["author_id"],
                        "Text" => $comment["html_body"],
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
        if ($flag === '') {
            $comments = $this->comments;
        } elseif ($flag === 'str') {
            foreach ($this->comments as $comment) {
                $comments .=
                    "comment: ID: " . $comment["ID"] .
                    "; AuthorID:" . $comment["AuthorID"] .
                    "; Text:" . $comment["Text"] . ";";
            }
        }

        return $comments;
    }

    public function getTicketInfo($flag = '')
    {
        if ($flag === 'str') {
            $info = "" .
                $this->id . ", " .
                $this->description . ", " .
                $this->status . ", " .
                $this->priority . ", " .
                $this->agentId . ", " .
                $this->agentName . ", " .
                $this->agentEmale . ", " .
                $this->contactId . ", " .
                $this->contactName . ", " .
                $this->contactEmale . ", " .
                $this->groupId . ", " .
                $this->groupName . ", " .
                $this->companyId . ", " .
                $this->companyName . ", " .
                $this->getComments('str') . ";";
        } elseif ($flag === 'arr') {
            $info = [
                $this->id,
                $this->description,
                $this->status,
                $this->priority,
                $this->agentId,
                $this->agentName,
                $this->agentEmale,
                $this->contactId,
                $this->contactName,
                $this->contactEmale,
                $this->groupId,
                $this->groupName,
                $this->companyId,
                $this->companyName,
                $this->comments,
            ];
        } else {
            $info = [
                'Ticket ID' => $this->id,
                'Description' => $this->description,
                'Status' => $this->status,
                'Priority' => $this->priority,
                'Agent ID' => $this->agentId,
                'Agent Name' => $this->agentName,
                'Agent Email' => $this->agentEmale,
                'Contact ID' => $this->contactId,
                'Contact Name' => $this->contactName,
                'Contact Email' => $this->contactEmale,
                'Group ID' => $this->groupId,
                'Group Name' => $this->groupName,
                'Company ID' => $this->companyId,
                'Company Name' => $this->companyName,
                'Comments' => $this->comments,
            ];
        }

        return $info;
    }

}