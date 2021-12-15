<?php
require_once(__DIR__.'/../model/Ticket.php');
require_once(__DIR__.'/../repository/TicketRepository.php');
class ContactController{

    private $ticketRepository;

    public function __construct()
    {
        $this->ticketRepository = new TicketRepository();
    }

    public function index(){
        require_once(__DIR__."/../view/ContactView.php");
    }

    public function post(){
        header('Content-Type: application/json');
        if(!empty($_POST['email']) && is_numeric($_POST['sex']) && !empty($_POST['country']) && !empty($_POST['name']) && !empty($_POST['message'])){
        try {
            $ticket = new Ticket(null, $_POST['email'], $_POST['sex'], $_POST['country'], $_POST['name'], $_POST['message'], null);
            $this->ticketRepository->insert($ticket);
            die(json_encode(array("error" => 0, "message" => "We've received the message from you. We'll be back to you soon.")));
        }catch(Exception $e){
            die(json_encode(array("error" => 1, "message" => $e->getMessage())));
        }
        }
        die(json_encode(array("error" => 1, "message" => "No post data received.")));
    }
}