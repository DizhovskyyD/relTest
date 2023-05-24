<?php
namespace Zendesk;

use Exception;
use GuzzleHttp\Client;

/**
 *
 */
class Zendesk{
    private $subdomain;
    private $email;
    private $token;
    private $client;
    private $authenticateString;
    private $baseUri;

    public function __construct($subdomain, $email, $token)
    {
        $this->subdomain = $subdomain;
        $this->email = $email;
        $this->token = $token;
        $this->authenticateString = "Basic ".base64_encode("{$this->email}/token:{$this->token}")."";
        $this->baseUri = "https://{$this->subdomain}.zendesk.com/api/v2/";

        $this->client = new Client();
    }

    /**
     * Перевірка автентифікації через логін+токен
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function authenticate(): bool
    {
        try {
            $response = $this->client->request('POST',"{$this->baseUri}users/me.json",[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => "{$this->authenticateString}",
                    ],
                ]);

            if ($response->getStatusCode() == 200) {
                return true;
            }
        } catch (Exception $e) {
            // Handle authentication error
            return 'Authentication failed: ' . $e->getMessage();
        }

        // Authentication failed
        return false;
    }

    /**
     * @return string
     */
    public function getAuthenticateString(): string
    {
        return $this->authenticateString;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
}
