<?php
require_once(__DIR__ . "/../repository/TicketRepository.php");
require_once(__DIR__ . "/../repository/VisitorRepository.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");
require_once(__DIR__ . "/../repository/UserRepository.php");
require_once(__DIR__."/../util/AccessVerify.php");

class AdminDashboardController
{
    private $ticketController;
    private $visitorController;
    private $auditRepository;
    private $userRepository;

    /**
     * AdminDashboardController constructor.
     */
    public function __construct()
    {
        $this->ticketController = new TicketRepository();
        $this->visitorController = new VisitorRepository();
        $this->auditRepository = new AuditRepository();
        $this->userRepository = new UserRepository();
    }

    public function contactDelete(){
        verifyAdmin();
        verifyXML();
        header('Content-Type: application/json');
        if(isset($_POST['id']) && is_numeric($_POST['id'])){
            $ticket = $this->ticketController->get($_POST['id']);
            if($ticket != null){
                try {
                    $this->ticketController->delete($ticket);
                    die(json_encode(array("success" => true, "description" => "Ticket deleted successfuly.")));
                }catch(Exception $ex){
                    die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "Ticket wasnt found.")));
            }
        }else{
            die(json_encode(array("success" => false, "description" => "No post data")));
        }
    }

    public function post()
    {
        verifyAdmin();
        verifyXML();
        header('Content-Type: application/json');

        if (isset($_POST["reply_subject"]) &&
            isset($_POST["reply_message"]) &&
            isset($_POST["reply-email"]) &&
            isset($_POST["reply-id"])) {

            $subject = $_POST["reply_subject"];
            $message = $_POST["reply_message"];
            $email = $_POST["reply-email"];
            $id = $_POST["reply-id"];

//            mail($email, $subject, $message);

            try {
                $ticket = $this->ticketController->get($id);

                if($ticket != null){
                    $this->ticketController->delete($ticket);

                    die(json_encode(array(
                        "success" => true
                    )));
                }


            } catch (Exception $e) {

            }

        }

        die(json_encode(array(
            "success" => false
        )));
    }

    public function index()
    {
        verifyAdmin();
        verifyXML();
        $json = [];
        $tableBody = "";
        foreach ($this->ticketController->listAll() as $ticket) {
            $element = [];
            $element["id"] = $ticket->getId();
            $element["message"] = $ticket->getMessage();
            $element["country"] = $ticket->getCountry();
            $element["date"] = $ticket->getDate();
            $element["sex"] = $ticket->getSex();
            $element["name"] = $ticket->getName();
            $element["email"] = $ticket->getEmail();

            $json[] = $element;

            $tableBody .= "<tr>";
            $tableBody .= "<td>" . $ticket->getName() . "</td>";
            $tableBody .= "<td>" . $ticket->getSex() . "</td>";
            $tableBody .= "<td>" . $ticket->getCountry() . "</td>";
            $tableBody .= "<td>" . $ticket->getMessage() . "</td>";
            $tableBody .= "<td><button reply=\"" . $ticket->getId() . "\" type=\"button\" class=\"btn btn-blue\">Reply</button></td>";
            $tableBody .= "<td><button delete=\"" . $ticket->getId() . "\" type=\"button\" class=\"btn btn-danger\">Delete</button></td>";
            $tableBody .= "</tr>";
        }

        $users = $this->visitorController->countVisits();
        $clicks = $this->visitorController->count();
        try {
            $registered_users = count($this->userRepository->listAll());
        } catch (Exception $e) {
            $registered_users = "X";
        }
        $json = json_encode($json);
        $audits = $this->auditRepository->listAll();

        include(__DIR__ . "/../view/AdminDashboardView.php");
    }
}

?>