<?php

declare(strict_types=1);

namespace Zendesk;

use Exception;
use GuzzleHttp\Client;

class Group
{
    private $id;
    private $url;
    private $name;

    /**
     * @param Zendesk $connekt
     * @param $id
     */
    public function __construct(Zendesk $connekt, $id)
    {
        if ($connekt->authenticate()) {
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
            $response = $client->request('GET', "{$connekt->getBaseUri()}groups/{$id}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "{$connekt->getAuthenticateString()}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $group = json_decode((string) $response->getBody(), true)['group'];

                $this->setUrl($group['url']);
                $this->setName($group['name']);
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
     * @param mixed $name
     */
    private function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}