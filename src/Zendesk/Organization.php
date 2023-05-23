<?php

declare(strict_types=1);

namespace Zendesk;
use GuzzleHttp\Client;

class Organization
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
            $response = $client->request('GET',"{$connekt->getBaseUri()}organizations/{$id}",[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "{$connekt->getAuthenticateString()}",
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $organization = json_decode((string) $response->getBody(), true)['organization'];

                $this->setUrl($organization['url']);
                $this->setName($organization['name']);
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