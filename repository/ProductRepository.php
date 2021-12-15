<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/Product.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");


class ProductRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param Product $product
     */
    public function insert(Product $product)
    {
        $sql = "INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_icon`) VALUES (NULL, :name , :desc ,:icon); ";

        $queryEx = $this->connection->prepare($sql);

        $name = $product->getTitle();
        $desc = $product->getDescription();
        $img = $product->getImage();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":icon", $img);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "Product", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Product $product
     */
    public function update(Product $product)
    {
        $sql = "UPDATE `product` SET `product_name` = :name,
                `product_description` = :desc,
                `product_icon` =  :img
                WHERE `product`.`product_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $name = $product->getTitle();
        $desc = $product->getDescription();
        $img = $product->getImage();
        $id = $product->getId();

        $queryEx->bindparam(":name", $name);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "Product", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param Product $product
     */
    public function delete(Product $product)
    {
        $sql = "DELETE FROM `product` WHERE `product`.`product_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $product->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "Product", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return Product|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM product WHERE product_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapProduct($result);
    }



    /**
     * @param array $array
     * @return Product
     */
    private function mapProduct(array $array)
    {
        return new Product($array["product_id"]
            , $array["product_name"]
            , $array["product_description"]
            , $array["product_icon"]);
    }

    /**
     * @return Product[]
     * @throws Exception
     */
    public function listAll($limit = null)
    {
        $products = [];
        if(is_numeric($limit)){
            $limit = "LIMIT ".$limit;
        }else{
            $limit = "";
        }
        $sth = $this->connection->prepare("SELECT * FROM `product` ".$limit);
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $products[] = $this->mapProduct($array);
        }

        return $products;
    }
}
?>