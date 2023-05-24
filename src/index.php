<?php
//Headers csv file:
//Ticket ID, Description, Status, Priority, Agent ID, Agent Name, Agent Email,
//Contact ID, Contact Name, Contact Email, Group ID, Group Name, Company ID, Company Name, Comments.
use Zendesk\Zendesk;
use Zendesk\TicketsPages;
use Zendesk\TicketPage;
use Zendesk\User;
use Zendesk\Group;
use Zendesk\Organization;
use Zendesk\Ticket;

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

$rezults = array(['Ticket ID'], ['Description'], ['Status'], ['Priority'],
    ['Agent ID'], ['Agent Name'], ['Agent Email'],
    ['Contact ID'], ['Contact Name'], ['Contact Email'],
    ['Group ID'], ['Group Name'],
    ['Company ID'], ['Company Name'],
    ['Comments']);

$TicketPages = new TicketsPages($connect);


$tickets = (new TicketPage($connect))->getAllTicket();



/*foreach ($tickets["tickets"] as $ticket){
    $rezult = array();

    $thisTicket = new Ticket($connect, $ticket['id']);
    $agent = new User($connect,$ticket['submitter_id']);
    $contact = new User($connect,$ticket['requester_id']);
    $organization = new Organization($connect, $ticket['organization_id']);
    $group = new Group($connect,$ticket['group_id']);

    $rezult [] = $thisTicket->getId();
    $rezult [] = $thisTicket->getDescription();
    $rezult [] = $thisTicket->getStatus();
    $rezult [] = $thisTicket->getPriority();

    $rezult [] = $agent->getId();
    $rezult [] = $agent->getName();
    $rezult [] = $agent->getEmale();

    $rezult [] = $contact->getId();
    $rezult [] = $contact->getName();
    $rezult [] = $contact->getEmale();

    $rezult [] = $group->getId();
    $rezult [] = $group->getName();

    $rezult [] = $organization->getId();
    $rezult [] = $organization->getName();

    $rezult [] = $thisTicket->getComments("str");

}*/
var_dump($rezults);
?>