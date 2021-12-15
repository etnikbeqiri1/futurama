<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Order.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class OrderRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $database = new Database();
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Order $order
     * @throws Exception
     */
    public function insert(Order $order)
    {
        $sql = "INSERT INTO `order` (`order_id`, `user_id`, `order_name`, `order_product`, `order_budget`, `order_status`, `order_date`) VALUES (NULL, :user_id, :name, :product, :budget, :status, current_timestamp()); ";

        $queryEx = $this->connection->prepare($sql);

        $name = $order->getName();
        $userid = $order->getUserId();
        $product = $order->getProduct();
        $status = $order->getStatus();
        $budget = $order->getBudget();



        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":user_id", $userid);
        $queryEx->bindparam(":product", $product);
        $queryEx->bindparam(":status", $status);
        $queryEx->bindparam(":budget", $budget);
        $queryEx->execute();

        $id = $this->connection->lastInsertId();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Order", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);

        return $this->get($id);
    }

    /**
     * @param Order $order
     */
    public function update(Order $order)
    {
        $sql = "UPDATE `order` SET `order_name` = :name,
                `user_id` = :user_id,
                `order_product` = :product,
                `order_budget` =  :budget,
                `order_status` = :status,
                `order_date` = :time
                WHERE `order`.`order_id` = :id;";

        $queryEx = $this->connection->prepare($sql);
        $timex = time();
        $name = $order->getName();
        $user_id = $order->getUserId();
        $product = $order->getProduct();
        $status = $order->getStatus();
        $budget = $order->getBudget();
        $id = $order->getId();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":user_id", $user_id);
        $queryEx->bindparam(":product", $product);
        $queryEx->bindparam(":status", $status);
        $queryEx->bindparam(":budget", $budget);
        $queryEx->bindparam(":time", $timex);
        $queryEx->bindparam(":id", $id);

        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Order", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Order $order
     */
    public function delete(Order $order)
    {
        $sql = "UPDATE `order` SET order_status='closed' WHERE `order`.`order_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $order->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Order", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return Order|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM `order` WHERE order_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapOrder($result);
    }



    /**
     * @param array $array
     * @return Order
     */
    private function mapOrder(array $array)
    {
        return new Order($array["order_id"]
            , $array["user_id"]
            , $array["order_name"]
            , $array["order_product"]
            , $array["order_budget"]
            , $array["order_status"]
            , $array["order_date"]);
    }

    /**
     * @return Order[]
     * @throws Exception
     */
    public function listAll($limit = null)
    {
        $orders = [];
        if(is_numeric($limit)){
            $limit = "LIMIT ".$limit;
        }else{
            $limit = "";
        }
        $sth = $this->connection->prepare("SELECT * FROM `order` ".$limit);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $orders[] = $this->mapOrder($array);
        }

        return $orders;
    }

    /**
     * @return Order[]
     * @throws Exception
     */
    public function listAllNonClosed($user_id)
    {
        $orders = [];
        $sth = $this->connection->prepare("SELECT * FROM `order` where user_id=:user_id AND order_status != 'closed'");
        $sth->bindparam(":user_id", $user_id);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $orders[] = $this->mapOrder($array);
        }

        return $orders;
    }

    public function listAllNonClosedAdmin()
    {
        $orders = [];
        $sth = $this->connection->prepare("SELECT * FROM `order` where  order_status != 'closed'");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $orders[] = $this->mapOrder($array);
        }

        return $orders;
    }

}
?>
