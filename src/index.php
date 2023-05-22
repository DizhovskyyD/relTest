<?php
//Headers csv file:
//Ticket ID, Description, Status, Priority, Agent ID, Agent Name, Agent Email,
//Contact ID, Contact Name, Contact Email, Group ID, Group Name, Company ID, Company Name, Comments.
use Zendesk\Zendesk;
use Zendesk\ZendeskUser;
use Zendesk\ZendeskTicket;

require 'vendor/autoload.php';

//дістати змінні з .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//прописати змінні для роботи з глобальних змінних
$subdomain = $_ENV['API_SUBDOMAIN'];
$email = $_ENV['API_EMAIL'];
$tokenApi = $_ENV['API_TOKEN'];

//перевірка з'єднання
$connect = new Zendesk($subdomain, $email, $tokenApi);

$answer = $connect->authenticate();
var_dump($answer);

$rezults = array(['Ticket ID'], ['Description'], ['Status'], ['Priority'],
    ['Agent ID'], ['Agent Name'], ['Agent Email'],
    ['Contact ID'], ['Contact Name'], ['Contact Email'],
    ['Group ID'], ['Group Name'],
    ['Company ID'], ['Company Name'],
    ['Comments']);

$tickets = (new ZendeskTicket($connect))->getAllTicket();

foreach ($tickets["tickets"] as $ticket){
    $rezult = array();

    $rezult ['Ticket ID'] =  $ticket['id'];
    $rezult ['Description'] =$ticket['description'];
    $rezult ['Status'] =$ticket['status'];
    $rezult ['Priority'] = $ticket['priority'];
    $rezult ['Agent ID'] =  $ticket['submitter_id'];
    $rezult ['Agent Name'] = (new ZendeskUser($connect))->getUserName($ticket['submitter_id']);
    $rezult ['Agent Email'] = (new ZendeskUser($connect))->getUserEmaile($ticket['submitter_id']);
    $rezult ['Contact ID'] = $ticket['requester_id'];
    $rezult ['Contact Name'] = (new ZendeskUser($connect))->getUserName($ticket['requester_id']);
    $rezult ['Contact Email'] = (new ZendeskUser($connect))->getUserEmaile($ticket['requester_id']);
    $rezult ['Group ID'] = $ticket['group_id'];
    $rezult ['Group Name'] = $ticket[''];
    $rezult ['Company ID'] = $ticket['organization_id'];
    $rezult ['Company Name'] = $ticket[''];
    $rezult ['Comments'] = (new ZendeskTicket($connect))->getAllCommentsInTicket($ticket['id'],);

    echo ($rezult);
}

?>