<?php
require_once(__DIR__ . "/../core/Database.php");
require_once(__DIR__ . "/../model/WhoAreWe.php");
require_once(__DIR__ . "/../util/Logging.php");
require_once(__DIR__ . "/../repository/AuditRepository.php");

class WhoAreWeRepository
{
    private $connection;
    private $auditRepository;

    public function __construct()
    {
        $this->connection = Database::getConn();
        $this->auditRepository = new AuditRepository();

    }

    /**
     * @param WhoAreWe $whoAreWe
     */
    public function insert(WhoAreWe $whoAreWe)
    {
        $sql = "INSERT INTO `whoarewe` (`whoarewe_id`, `whoarewe_title`, `whoarewe_description`, `whoarewe_img`) VALUES (NULL, :title, :desc , :img); ";

        $queryEx = $this->connection->prepare($sql);

        $title = $whoAreWe->getTitle();
        $desc = $whoAreWe->getDescription();
        $img = $whoAreWe->getImg();

        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "insert", "WhoAreWe", $this->connection->lastInsertId(), "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param WhoAreWe $whoAreWe
     */
    public function update(WhoAreWe $whoAreWe)
    {
        $sql = "UPDATE `whoarewe` SET `whoarewe_title` = :title,
                `whoarewe_description` = :desc,
                `whoarewe_img` =  :img
                WHERE `whoarewe`.`whoarewe_id` = :id;";

        $queryEx = $this->connection->prepare($sql);

        $title = $whoAreWe->getTitle();
        $desc = $whoAreWe->getDescription();
        $img = $whoAreWe->getImg();
        $id = $whoAreWe->getId();

        $queryEx->bindparam(":title", $title);
        $queryEx->bindparam(":desc", $desc);
        $queryEx->bindparam(":img", $img);
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "update", "WhoAreWe", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param WhoAreWe $whoAreWe
     */
    public function delete(WhoAreWe $whoAreWe)
    {
        $sql = "DELETE FROM `whoarewe` WHERE `whoarewe`.`whoarewe_id` = :id";
        $queryEx = $this->connection->prepare($sql);
        $id = $whoAreWe->getId();
        $queryEx->bindparam(":id", $id);
        $queryEx->execute();

        $audit = new Audit(null, $_SESSION["id"], "delete", "WhoAreWe", $id, "", date('Y-m-d H:i:s'));
        $this->auditRepository->insert($audit);
    }

    /**
     * @param $id
     * @return WhoAreWe|null
     * @throws Exception
     */
    public function get($id){
        $sql = $this->connection->prepare("SELECT * FROM whoarewe WHERE whoarewe_id = :id");
        $sql->bindparam(":id", $id);
        $sql->execute();

        $result = $sql->fetch();
        if($result == null){
            return null;
        }

        return $this->mapWhoAreWe($result);
    }


    private function mapWhoAreWe(array $array)
    {
        $whoAreWe = new WhoAreWe($array["whoarewe_id"]
            , $array["whoarewe_title"]
            , $array["whoarewe_description"]
            , $array["whoarewe_img"]);
        return $whoAreWe;
    }

    /**
     * @return WhoAreWe[]
     * @throws Exception
     */
    public function listAll()
    {
        $whoAreWee = [];
        $sth = $this->connection->prepare("SELECT * FROM `whoarewe`");
        $sth->execute();

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as $array) {
            $whoAreWee[] = $this->mapWhoAreWe($array);
        }
        return $whoAreWee;
    }
}
?>