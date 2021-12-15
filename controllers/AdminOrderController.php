<?php

require_once(__DIR__.'/../repository/OrderRepository.php');
require_once(__DIR__.'/../util/AccessVerify.php');
require_once(__DIR__.'/../repository/ProductRepository.php');
require_once(__DIR__.'/../repository/UserRepository.php');
class AdminOrderController
{
    private $orderRepository;
    private $productRepository;
    private $userRepository;
    public function __construct()
    {

        $this->orderRepository = new OrderRepository();
        $this->productRepository = new ProductRepository();
        $this->userRepository = new UserRepository();
    }

    public function delete(){
        verifyXML();
        verifyAdmin();
        if(is_numeric($_POST['id'])){
            header('Content-Type: application/json');
            $order = $this->orderRepository->get($_POST['id']);
            if($order != null){
                try{
                    $this->orderRepository->delete($order);
                    die(json_encode(array("success" => true, "description" => "Successfuly deleted the order")));
                }catch(Exception $ex){
                    die(json_encode(array("succcess" => false, "description" => $ex->getMessage())));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "Order wasn't found")));
            }
        }
    }

    public function index(){
        verifyAdmin();
        verifyXML();
        $tableBody = "";
        foreach ($this->orderRepository->listAllNonClosedAdmin() as $order) {
            $tableBody .= "<tr>";
            $tableBody .= "<td>" . $order->getId() . "</td>";
            $tableBody .= "<td>" . $order->getName() . "</td>";
            $tableBody .= "<td>" . $this->productRepository->get($order->getProduct())->getTitle() . "</td>";
            $tableBody .= "<td>" . $this->userRepository->get($order->getUserId())->getFullName(). "</td>";
            $tableBody .= "<td>" . $order->getBudget() . "</td>";
            $tableBody .= "<td>" . $order->getStatus() . "</td>";
            $tableBody .= "<td><button open=\"Order?id=" . $order->getId() . "\" type=\"button\" class=\"btn btn-blue\">Manage</button></td>";
            $tableBody .= "<td><button delete=\"" . $order->getId() . "\" type=\"button\" class=\"btn btn-danger\">Delete</button></td>";
            $tableBody .= "</tr>";
        }
        require_once(__DIR__.'/../view/AdminOrderView.php');
    }
}