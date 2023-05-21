<?php
//Headers csv file:
//Ticket ID, Description, Status, Priority, Agent ID, Agent Name, Agent Email,
//Contact ID, Contact Name, Contact Email, Group ID, Group Name, Company ID, Company Name, Comments.
use Zendesk\Zendesk;
require 'vendor/autoload.php';

//дістати змінні з .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//прописати змінні для роботи з глобальних змінних
$subdomain = $_ENV['API_SUBDOMAIN'];
$email = $_ENV['API_EMAIL'];
$tokenApi = $_ENV['API_TOKEN'];

$connect = new Zendesk($subdomain, $email, $tokenApi);

$answer = $connect->authenticate();
var_dump($answer);

$users = new ZendeskUser($connect);
//var_dump($tickets->getAllTicket());
//var_dump("Basic ".base64_encode("{$email}/token:{$tokenApi}")."");
//var_dump($connect->authenticateString);



?>