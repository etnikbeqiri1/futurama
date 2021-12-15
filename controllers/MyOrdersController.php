<?php
require_once(__DIR__ . "/../repository/OrderRepository.php");
require_once(__DIR__ . "/../repository/ProductRepository.php");
require_once(__DIR__ . "/../repository/MessageRepository.php");
require_once(__DIR__ . "/../util/AccessVerify.php");

class MyOrdersController
{
    private $orderRepository;
    private $productRepository;
    private $messageRepository;

    /**
     * MyOrdersController constructor.
     */
    public function __construct()
    {
        verifyUser();
        verifyXML();
        $this->orderRepository = new OrderRepository();
        $this->productRepository = new ProductRepository();
        $this->messageRepository = new MessageRepository();
    }

    public function delete(){
        verifyXML();
        verifyUser();
        if(is_numeric($_POST['id'])){
            header('Content-Type: application/json');
            $order = $this->orderRepository->get($_POST['id']);
            if($order != null ){
                if($order->getUserId() == $_SESSION['id']) {
                    try {
                        $this->orderRepository->delete($order);
                        die(json_encode(array("success" => true, "description" => "Order deleted successfuly")));
                    } catch (Exception $ex) {
                        die(json_encode(array("success" => false, "description" => $ex->getMessage())));
                    }
                }else{
                    die(json_encode(array("success" => false, "description" => "This isn't your order for delete!!!!")));
                }
            }else{
                die(json_encode(array("success" => false, "description" => "Order wasn't found the database")));
            }
        }
    }

    public function index()
    {
        $options = $this->getSelectOptions();
        $tableBody = $this->getTableBody();
        include(__DIR__ . "/../view/MyOrdersView.php");
    }

    public function post()
    {
        header('Content-Type: application/json');
        if (isset($_POST["product_name"]) && isset($_POST["budget"]) && isset($_POST["product"]) && isset($_POST["description"])) {
            $this->makeOrder();
        }
    }

    private function makeOrder()
    {
        try {
            $order = new Order(null, $_SESSION["id"], $_POST["product_name"], $_POST["product"], $_POST["budget"], "pending", date('Y-m-d H:i:s'));
            $o = $this->orderRepository->insert($order);
            $message = new Message(null, 1, $_POST["description"], date('Y-m-d H:i:s'), $o->getId());
            $this->messageRepository->insert($message);

            die(json_encode(array("success" => true, "message" => "Order Created Successfully")));

        } catch (Exception $e) {
            die(json_encode(array("success" => false, "message" => $e->getMessage())));
        }
    }

    private function getSelectOptions()
    {
        $options = "";
        foreach ($this->productRepository->listAll() as $product) {
            $options .= " <option value=\"" . $product->getId() . "\">" . $product->getTitle() . "</option>";
        }
        return $options;
    }

    private function getTableBody()
    {
        $tableBody = "";
        try {
            foreach ($this->orderRepository->listAllNonClosed($_SESSION['id']) as $order) {
                $tableBody .= "<tr>";
                $tableBody .= "<td>" . $order->getId() . "</td>";
                $tableBody .= "<td>" . $order->getName() . "</td>";
                $tableBody .= "<td>" . $this->productRepository->get($order->getProduct())->getTitle() . "</td>";
                $tableBody .= "<td>" . $order->getBudget() . "</td>";
                $tableBody .= "<td>" . $order->getStatus() . "</td>";
                $tableBody .= "<td><button open=\"Order?id=" . $order->getId() . "\" type=\"button\" class=\"btn btn-blue\">Manage</button></td>";
                $tableBody .= "<td><button delete=\"" . $order->getId() . "\" type=\"button\" class=\"btn btn-danger\">Delete</button></td>";
                $tableBody .= "</tr>";
            }
        } catch (Exception $e) {
        }

        return $tableBody;
    }
}

?>