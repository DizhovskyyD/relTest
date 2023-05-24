<?php

use Zendesk\Zendesk;
use Zendesk\TicketsPages;
use Zendesk\TicketPage;
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

//Headers csv file
$rezultsHeader = [
    'Ticket ID',
    'Description',
    'Status',
    'Priority',
    'Agent ID',
    'Agent Name',
    'Agent Email',
    'Contact ID',
    'Contact Name',
    'Contact Email',
    'Group ID',
    'Group Name',
    'Company ID',
    'Company Name',
    'Comments',
];
$rezultsBody = [];

$fp = fopen('databse.csv', 'a');
fputcsv($fp, $rezultsHeader);

$TicketPages = new TicketsPages($connect);

if ($TicketPages->paginationAviable()) {
    $pagesNumber = $TicketPages->getAllPagesNumber();

    foreach ($pagesNumber as $page) {
        $tickets = (new TicketPage($connect, $page))->getAllTicketsId();

        foreach ($tickets as $ticketId) {
            $thisTicket = new Ticket($connect, $ticketId);
            fputcsv($fp, $thisTicket->getTicketInfo('arr'));
        }
    }
} else {
    $tickets = (new TicketPage($connect))->getAllTicketsId();
    foreach ($tickets as $ticketId) {
        $thisTicket = new Ticket($connect, $ticketId);
        fputcsv($fp, $thisTicket->getTicketInfo('arr'));
    }
}

fclose($fp);
?>