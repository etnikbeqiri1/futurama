<?php
require_once(__DIR__ . "/../repository/OrderRepository.php");
require_once(__DIR__ . "/../repository/UserRepository.php");
require_once(__DIR__ . "/../repository/ProductRepository.php");
require_once(__DIR__ . "/../repository/MessageRepository.php");
require_once(__DIR__ . "/../repository/RoleRepository.php");

class OrderController
{
    private $orderRepository;
    private $userRepository;
    private $productRepository;
    private $messageRepository;
    private $roleRepository;
    private $order;
    private $statuses = ["pending", "accepted","working" ,"closed"];
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->userRepository = new UserRepository();
        $this->productRepository = new ProductRepository();
        $this->messageRepository = new MessageRepository();
        $this->roleRepository = new RoleRepository();
    }

    public function index()
    {
        $this->checkAccess();
        $id = $this->order->getId();
        $title = $this->order->getName();
        $user = $this->userRepository->get($this->order->getUserId())->getUsername();
        $product = $this->productRepository->get($this->order->getProduct())->getTitle();
        $budget = $this->order->getBudget();
        $status = $this->order->getStatus();

        $session_user = $this->userRepository->get($_SESSION["id"]);
        if($session_user->getRole() == 0){
            $select = "<select id='status-select'>";
        }else{
            $select = "<select id='status-select' disabled>";
        }

        foreach ($this->statuses as $statusthis) {
            if($status == $statusthis){
                $select .= sprintf("<option value=\"%s\" selected>%s</option>", $statusthis, $statusthis);
            }else{
                $select .= sprintf("<option value=\"%s\">%s</option>", $statusthis, $statusthis);
            }
        }
        $select .= "</select>";


        include(__DIR__ . "/../view/OrderView.php");
    }

    private function checkAccess()
    {
        if (!isset($_GET["id"]) || !isset($_SESSION["id"])) {
            $this->htmlRedirect("dashboard");
        }

        $id = $_GET["id"];

        try {
            if (($this->order = $this->orderRepository->get($id)) == null) {
                $this->htmlRedirect("dashboard");
            }
        } catch (Exception $e) {
            $this->htmlRedirect("dashboard");
        }

        $session_user = $this->userRepository->get($_SESSION["id"]);

        if ($session_user->getId() != $this->order->getUserId() && $session_user->getRole() != 0) {
            $this->htmlRedirect("dashboard");
        }


    }

    public function sendMessage()
    {
        header('Content-Type: application/json');
        $this->checkAccess();
        $session_user = $this->userRepository->get($_SESSION["id"]);

        if (!isset($_POST["message"])) {
            exit;
        }
        if (!isset($_POST["message"])) {
            exit;
        }
        if (strlen($_POST["message"]) < 1) {
            exit;
        }
        $message = new Message(null, $this->roleRepository->get($session_user->getRole())->getId(),
            $_POST["message"],
            date('Y-m-d H:i:s'),
            $_GET["id"]);

        $this->messageRepository->insert($message);
    }

    public function changeStatus(){
        header('Content-Type: application/json');
        $this->checkAccess();
        $session_user = $this->userRepository->get($_SESSION["id"]);

        if (!isset($_POST["status"])) {
            exit;
        }
        if ($session_user->getRole() != 0) {
            exit;
        }
        if(!in_array($_POST["status"] , $this->statuses)){
            exit;
        }

        $order = $this->orderRepository->get($_GET["id"]);
        $order->setStatus($_POST["status"]);

        $this->orderRepository->update($order);

    }

    public function listMessages(){

        $this->checkAccess();
        header('Content-Type: application/json');
        $session_user = $this->userRepository->get($_SESSION["id"]);

        if(!isset($_POST["last_message"])){
            $last_message = 0;
        }else{
            $last_message = $_POST["last_message"];
        }
        $json = [];
        try {
            $messages = $this->messageRepository->listMessagesNewerThen($_GET["id"],date('Y-m-d H:i:s', $last_message));
            foreach ($messages as $message){
                $array = [];
                $array["sender"] = $message->getMessageSender() == $session_user->getRole() ? "sent":"received";
                $array["message"] = $message->getText();
                $array["date"] = strtotime($message->getDate());
                $json[] = $array;
            }
        } catch (Exception $e) {
            log_message($e);
        }
        die(json_encode($json));
    }

    private function htmlRedirect($url)
    {
        echo sprintf("<script>window.location.replace(\"%s\");</script>", $url);
        exit;
    }
}